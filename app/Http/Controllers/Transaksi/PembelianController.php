<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;
use App\Models\Transaksi\Pembelian;
use App\Models\Masterdata\Supplier;
use App\Models\Masterdata\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Masterdata\Coa;
use Illuminate\Support\Str;
use App\Models\Laporan\JurnalUmum;
use Illuminate\Support\Carbon;

class PembelianController extends Controller
{
    public function index(Request $request)
    {
        $id_perusahaan = Auth::user()->id_perusahaan;
        $filter = $request->input('filter');
        $search = $request->input('search', '');

        $query = Pembelian::with(['pembelianDetails', 'supplierRelation'])
            ->where('id_perusahaan', $id_perusahaan);

        if ($search) {
            $query->where('no_transaksi_pembelian', 'like', "%{$search}%");
        }

        if ($filter === 'lunas') {
            $query->whereColumn('total_dibayar', '>=', 'total');
        } elseif ($filter === 'belum_lunas') {
            $query->whereColumn('total_dibayar', '<', 'total');
        }

        $pembelian = $query->paginate(10);

        return view('transaksi.pembelian.index', compact('pembelian', 'filter', 'search'));
    }

    public function create()
    {
        $id_perusahaan = Auth::user()->id_perusahaan;
        $suppliers = Supplier::where('id_perusahaan', $id_perusahaan)->get();
        $produk = Produk::where('id_perusahaan', $id_perusahaan)->get();

        return view('transaksi.pembelian.create', compact('suppliers', 'produk'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'supplier' => 'required|exists:supplier,id_supplier',
            'tipe_pembayaran' => 'required|in:tunai,kredit',
            'produk' => 'required|array',
            'produk.*.id_produk' => 'required|exists:produk,id_produk',
            'produk.*.qty' => 'required|integer|min:1',
            'produk.*.harga' => 'required|numeric|min:0',
            'produk.*.dibayar' => 'required|numeric|min:0'
        ]);

        // Store the Pembelian (Purchase)
        $pembelian = Pembelian::create([
            'tanggal_pembelian' => $request->tanggal,
            'supplier' => $request->supplier,
            'tipe_pembayaran' => $request->tipe_pembayaran,
            'id_perusahaan' => Auth::user()->id_perusahaan,
        ]);

        $total = 0;
        $total_dibayar = 0;

        foreach ($request->produk as $item) {
            $subtotal = $item['qty'] * $item['harga'];
            $total += $subtotal;
            $total_dibayar += $item['dibayar'];

            $pembelian->pembelianDetails()->create([
                'id_produk' => $item['id_produk'],
                'qty' => $item['qty'],
                'harga' => $item['harga'],
                'dibayar' => $item['dibayar'],
            ]);
        }

        $status = ($total_dibayar >= $total) ? 'Lunas' : 'Belum Lunas';

        $pembelian->update([
            'total' => $total,
            'total_dibayar' => $total_dibayar,
            'status' => $status,
        ]);

        // Create Journal Entries for the Pembelian (Purchase)
        $this->createJournalEntries($pembelian);

        return redirect()->route('pembelian.index')->with('success', 'Pembelian created successfully.');
    }

    public function destroy($id_pembelian)
    {
        $id_perusahaan = Auth::user()->id_perusahaan;

        $pembelian = Pembelian::where('id_pembelian', $id_pembelian)
            ->where('id_perusahaan', $id_perusahaan)
            ->firstOrFail();

        $pembelian->delete();

        return redirect()->route('pembelian.index')->with('success', 'Pembelian deleted successfully.');
    }

    public function show($id_pembelian)
    {
        $id_perusahaan = Auth::user()->id_perusahaan;

        $pembelian = Pembelian::with(['pembelianDetails', 'supplierRelation', 'pelunasanPembelian'])
            ->where('id_pembelian', $id_pembelian)
            ->where('id_perusahaan', $id_perusahaan)
            ->firstOrFail();

        $status = $pembelian->total_dibayar >= $pembelian->total
            ? '<span class="badge badge-success">Lunas</span>'
            : '<span class="badge badge-danger">Belum Lunas</span>';

        return view('transaksi.pembelian.detail', compact('pembelian', 'status'));
    }

    public function pelunasan($id_pembelian)
    {
        $pembelian = Pembelian::with('pembelianDetails')->findOrFail($id_pembelian);

        // Calculate the remaining payment
        $remainingPayment = $pembelian->total - $pembelian->total_dibayar;

        // Check if there's any remaining payment to process
        if ($remainingPayment <= 0) {
            return redirect()->route('pembelian.index')->with('error', 'Pembelian sudah lunas.');
        }

        // Create a pelunasan entry
        $pembelian->pelunasanPembelian()->create([
            'id_produk' => $pembelian->pembelianDetails->first()->id_produk, // Provide valid id_produk
            'total_pelunasan' => $remainingPayment,
            'tanggal_pelunasan' => now(),
        ]);

        // Update total_dibayar and set status to 'Lunas'
        $pembelian->total_dibayar += $remainingPayment;
        $pembelian->status = 'Lunas'; // Set status to Lunas
        $pembelian->save();

        // Now, create the journal entries after the payment (pelunasan) is processed
        $this->createJournalEntries($pembelian);

        return redirect()->route('pembelian.index')->with('success', 'Pelunasan berhasil. Status Pembelian telah diubah menjadi Lunas.');
    }


    // Method to create journal entries for a Pembelian (Purchase)
    protected function createJournalEntries(Pembelian $pembelian)
    {
        $perusahaanId = $pembelian->id_perusahaan;

        // Get the COA (Chart of Accounts) for relevant accounts
        $akunPembelian = Coa::where('id_coa', '13')->first(); // Pembelian account
        $akunUtang = Coa::where('id_coa', '7')->first(); // Utang account
        $akunKas = Coa::where('id_coa', '1')->first(); // Kas account
        $transactionId = Str::uuid();

        // Prepare transaction entries
        $transactionData = [
            'tanggal_jurnal' => Carbon::now(), // Current date
            'transaction_id' => $transactionId,
            'entries' => []
        ];

        // Check if payment type is 'tunai' (cash)
        if ($pembelian->tipe_pembayaran === 'tunai') {
            // Debit Pembelian account and Credit Utang account
            $transactionData['entries'][] = [
                'id_coa' => $akunPembelian->id_coa,
                'nama_akun' => $akunPembelian->nama_akun,
                'kode_akun' => $akunPembelian->kode_akun,
                'debit' => $pembelian->total, // Debit Pembelian
                'credit' => null, // No credit
                'transaction_id' => $transactionId, // Reference the same transaction ID
            ];
            $transactionData['entries'][] = [
                'id_coa' => $akunKas->id_coa,
                'nama_akun' => $akunKas->nama_akun,
                'kode_akun' => $akunKas->kode_akun,
                'debit' => null, // No debit
                'credit' => $pembelian->total, // Credit Kas
                'transaction_id' => $transactionId, // Reference the same transaction ID
            ];
        }
        // Check if payment type is 'kredit' (credit)
        elseif ($pembelian->tipe_pembayaran === 'kredit') {
            // Debit Utang account and Credit Kas account for the first payment
            $firstPaymentAmount = $pembelian->pembelianDetails->sum('dibayar'); // Assuming first payment is the total of dibayar field

            $transactionData['entries'][] = [
                'id_coa' => $akunPembelian->id_coa,
                'nama_akun' => $akunPembelian->nama_akun,
                'kode_akun' => $akunPembelian->kode_akun,
                'debit' => $firstPaymentAmount, // Debit Utang for the first payment
                'credit' => null, // No credit
                'transaction_id' => $transactionId, // Reference the same transaction ID
            ];
            $transactionData['entries'][] = [
                'id_coa' => $akunUtang->id_coa,
                'nama_akun' => $akunUtang->nama_akun,
                'kode_akun' => $akunUtang->kode_akun,
                'debit' => null, // No debit
                'credit' => $firstPaymentAmount, // Credit Kas
                'transaction_id' => $transactionId, // Reference the same transaction ID
            ];
        }

        // Add the entry for pelunasan (if any payment is made)
        if ($pembelian->pelunasanPembelian()->exists()) {
            $pelunasanAmount = $pembelian->pelunasanPembelian->sum('total_pelunasan');

            // Debit the "Utang" account and Credit the "Kas" account for the pelunasan payment
            $transactionData['entries'][] = [
                'id_coa' => $akunUtang->id_coa,
                'nama_akun' => $akunUtang->nama_akun,
                'kode_akun' => $akunUtang->kode_akun,
                'debit' => $pelunasanAmount, // Debit Utang
                'credit' => null, // No credit
                'transaction_id' => $transactionId, // Reference the same transaction ID
            ];
            $transactionData['entries'][] = [
                'id_coa' => $akunKas->id_coa,
                'nama_akun' => $akunKas->nama_akun,
                'kode_akun' => $akunKas->kode_akun,
                'debit' => null, // No debit
                'credit' => $pelunasanAmount, // Credit Kas
                'transaction_id' => $transactionId, // Reference the same transaction ID
            ];
        }

        // Create journal entries for this transaction
        JurnalUmum::createFromTransaction($transactionData, $perusahaanId);
    }
}
