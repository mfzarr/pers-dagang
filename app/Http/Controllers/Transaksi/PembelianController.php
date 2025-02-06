<?php

namespace App\Http\Controllers\Transaksi;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Masterdata\Coa;
use Illuminate\Support\Carbon;
use App\Models\Masterdata\Produk;
use App\Models\Laporan\JurnalUmum;
use Illuminate\Support\Facades\DB;
use App\Models\Masterdata\Supplier;
use App\Models\Transaksi\Pembelian;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Masterdata\stok_produk;
use App\Models\Transaksi\Pembeliandetail;
use App\Models\Laporan\StokProduk;
use App\Models\Laporan\RekapHutang;


class PembelianController extends Controller
{

    // protected function updateStokProduk(Pembeliandetail $pembelianDetail)
    // {
    //     DB::transaction(function () use ($pembelianDetail) {
    //         $produk = Produk::findOrFail($pembelianDetail->id_produk);
    //         $stokSebelum = $produk->stok;
    //         $produk->stok += $pembelianDetail->kuantitas;
    //         $produk->save();

    //         StokProduk::create([
    //             'id_produk' => $pembelianDetail->id_produk,
    //             'id_pembelian_detail' => $pembelianDetail->id_pembelian_detail,
    //             'jumlah' => $pembelianDetail->kuantitas,
    //             'jenis' => 'pembelian',
    //             'stok_sebelum' => $stokSebelum,
    //             'stok_sesudah' => $produk->stok,
    //         ]);
    //     });
    // }

    public function index(Request $request)
    {
        $id_perusahaan = Auth::user()->id_perusahaan;
        $filter = $request->input('filter');
        $search = $request->input('search', '');
        $supplier_filter = $request->input('supplier');
        $month = $request->input('month');

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

        if ($supplier_filter) {
            $query->where('supplier', $supplier_filter);
        }

        if ($month) {
            $query->whereMonth('tanggal_pembelian', Carbon::parse($month)->month)
                ->whereYear('tanggal_pembelian', Carbon::parse($month)->year);
        }

        $pembelian = $query->get(); // Remove pagination

        // Fetch all suppliers for the dropdown
        $suppliers = Supplier::where('id_perusahaan', $id_perusahaan)->get();

        return view('transaksi.pembelian.index', compact('pembelian', 'filter', 'search', 'suppliers', 'supplier_filter', 'month'));
    }

    public function create()
    {
        $id_perusahaan = Auth::user()->id_perusahaan;
        $suppliers = Supplier::where('id_perusahaan', $id_perusahaan)->with('products')->get();

        // Fetch all products for the company
        $produk = Produk::where('id_perusahaan', $id_perusahaan)->get();

        return view('transaksi.pembelian.create', compact('suppliers', 'produk'));
    }

    public function getProductsBySupplier($supplierId)
    {
        $id_perusahaan = Auth::user()->id_perusahaan;
        $products = Produk::where('id_perusahaan', $id_perusahaan)
            ->where('id_supplier', $supplierId)
            ->get();

        return response()->json($products);
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

        // foreach ($request->produk as $item) {
        //     $pembelianDetail = $pembelian->pembelianDetails()->create([
        //         'id_produk' => $item['id_produk'],
        //         'harga' => $item['harga'],
        //         'kuantitas' => $item['kuantitas'],
        //     ]);

        //     $this->updateStokProduk($pembelianDetail);
        // }

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

            // Update the stock of the selected products
            $produk = Produk::find($item['id_produk']);
            $produk->stok += $item['qty'];
            $produk->save();

            //Update Stok Masuk
            $stok = stok_produk::firstOrCreate(
                ['id_produk' => $item['id_produk']],
                ['stok_masuk' => 0, 'stok_keluar' => 0, 'stok_akhir' => 0]
            );
            $stok->stok_masuk += $item['qty'];
            $stok->save();
        }

        $status = ($total_dibayar >= $total) ? 'Lunas' : 'Belum Lunas';

        $pembelian->update([
            'total' => $total,
            'total_dibayar' => $total_dibayar,
            'status' => $status,
        ]);

        // If the payment type is "kredit", store the debt in RekapHutang
        if ($pembelian->tipe_pembayaran === 'kredit') {
            $sisa_hutang = $pembelian->total - $pembelian->total_dibayar;

            RekapHutang::create([
                'pembelian_id' => $pembelian->id_pembelian,
                'id_supplier' => $pembelian->supplier, // This will now work
                'total_hutang' => $pembelian->total,
                'total_dibayar' => $pembelian->total_dibayar,
                'sisa_hutang' => $sisa_hutang,
                'tenggat_pelunasan' => Carbon::parse($pembelian->tanggal_pembelian)->addMonth(),
            ]);
        }

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
        $akunPembelian = Coa::where('kode_akun', '1103')->first(); // Pembelian account
        $akunUtang = Coa::where('kode_akun', '2101')->first(); // Utang account
        $akunKas = Coa::where('kode_akun', '1101')->first(); // Kas account
        $tanggal_jurnal = $pembelian->tanggal_pembelian;
        $transactionId = Str::uuid();

        // Prepare transaction entries
        $transactionData = [
            'transaction_id' => $transactionId,
            'entries' => []
        ];

        // Check if payment type is 'tunai' (cash)
        if ($pembelian->tipe_pembayaran === 'tunai') {
            // Debit Pembelian account and Credit Utang account
            $transactionData['entries'][] = [
                'id_coa' => $akunPembelian->id_coa,
                'tanggal_jurnal' => $tanggal_jurnal,
                'nama_akun' => $akunPembelian->nama_akun,
                'kode_akun' => $akunPembelian->kode_akun,
                'debit' => $pembelian->total, // Debit Pembelian
                'credit' => null, // No credit
                'transaction_id' => $transactionId, // Reference the same transaction ID
            ];
            $transactionData['entries'][] = [
                'id_coa' => $akunKas->id_coa,
                'tanggal_jurnal' => $tanggal_jurnal,
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
            $sisaPayment = $pembelian->total - $firstPaymentAmount;

            $transactionData['entries'][] = [
                'id_coa' => $akunPembelian->id_coa,
                'tanggal_jurnal' => $tanggal_jurnal,
                'nama_akun' => $akunPembelian->nama_akun,
                'kode_akun' => $akunPembelian->kode_akun,
                'debit' => $pembelian->total, // Debit Utang for the first payment
                'credit' => null, // No credit
                'transaction_id' => $transactionId, // Reference the same transaction ID
            ];

            $transactionData['entries'][] = [
                'id_coa' => $akunKas->id_coa,
                'tanggal_jurnal' => $tanggal_jurnal,
                'nama_akun' => $akunKas->nama_akun,
                'kode_akun' => $akunKas->kode_akun,
                'debit' => null,
                'credit' => $firstPaymentAmount,
                'transaction_id' => $transactionId,
            ];

            $transactionData['entries'][] = [
                'id_coa' => $akunUtang->id_coa,
                'tanggal_jurnal' => $tanggal_jurnal,
                'nama_akun' => $akunUtang->nama_akun,
                'kode_akun' => $akunUtang->kode_akun,
                'debit' => null, // No debit
                'credit' => $sisaPayment, // Credit Kas
                'transaction_id' => $transactionId, // Reference the same transaction ID
            ];
        }

        // Create journal entries for this transaction
        JurnalUmum::createFromTransaction($transactionData, $perusahaanId);

        // Add the entry for pelunasan (if any payment is made)
        if ($pembelian->pelunasanPembelian()->exists()) {
            $pelunasanAmount = $pembelian->pelunasanPembelian->sum('total_pelunasan');
            $tanggal_pelunasan = Carbon::now();
            $pelunasanTransactionId = Str::uuid(); // New transaction ID for pelunasan

            // Prepare transaction entries for pelunasan
            $pelunasanTransactionData = [
                'transaction_id' => $pelunasanTransactionId,
                'entries' => []
            ];

            // Debit the "Utang" account and Credit the "Kas" account for the pelunasan payment
            $pelunasanTransactionData['entries'][] = [
                'id_coa' => $akunUtang->id_coa,
                'tanggal_jurnal' => $tanggal_pelunasan,
                'nama_akun' => $akunUtang->nama_akun,
                'kode_akun' => $akunUtang->kode_akun,
                'debit' => $pelunasanAmount, // Debit Utang
                'credit' => null, // No credit
                'transaction_id' => $pelunasanTransactionId, // Reference the new transaction ID
            ];
            $pelunasanTransactionData['entries'][] = [
                'id_coa' => $akunKas->id_coa,
                'tanggal_jurnal' => $tanggal_pelunasan,
                'nama_akun' => $akunKas->nama_akun,
                'kode_akun' => $akunKas->kode_akun,
                'debit' => null, // No debit
                'credit' => $pelunasanAmount, // Credit Kas
                'transaction_id' => $pelunasanTransactionId, // Reference the new transaction ID
            ];

            // Create journal entries for pelunasan transaction
            JurnalUmum::createFromTransaction($pelunasanTransactionData, $perusahaanId);
        }
    }

    public function rekapHutang(Request $request)
    {
        $id_perusahaan = Auth::user()->id_perusahaan;
        $month = $request->input('month', Carbon::now()->month);

        // Get pembelian data with tipe_pembayaran 'kredit'
        $pembelian = Pembelian::with(['pembelianDetails', 'supplierRelation'])
            ->where('id_perusahaan', $id_perusahaan)
            ->where('tipe_pembayaran', 'kredit')
            ->whereMonth('tanggal_pembelian', $month)
            ->get();

        foreach ($pembelian as $item) {
            $sisa_hutang = $item->total - $item->total_dibayar;

            // Check if record exists in RekapHutang
            $rekap = RekapHutang::updateOrCreate(
                ['pembelian_id' => $item->id_pembelian],
                [
                    'id_supplier' => $item->supplier,
                    'total_hutang' => $item->total,
                    'total_dibayar' => $item->total_dibayar,
                    'sisa_hutang' => $sisa_hutang,
                    'tenggat_pelunasan' => Carbon::parse($item->tanggal_pembelian)->addMonth()
                ]
            );

            $item->rekap = $rekap;
        }

        return view('transaksi.pembelian.rekap_hutang', compact('pembelian'));
    }

    public function updateDueDate(Request $request, $pembelian_id)
    {
        $rekap = RekapHutang::where('pembelian_id', $pembelian_id)->first();

        if (!$rekap) {
            return redirect()->back()->with('error', 'Data not found.');
        }

        $rekap->update([
            'tenggat_pelunasan' => $request->tenggat_pelunasan
        ]);

        return redirect()->back()->with('success', 'Due date updated successfully.');
    }

    public function updateBulk(Request $request)
{
    $request->validate([
        'id' => 'required|exists:rekap_hutang,id',
        'tenggat_pelunasan' => 'required|date',
    ]);

    try {
        DB::beginTransaction();

        $rekapHutang = RekapHutang::findOrFail($request->input('id'));
        $rekapHutang->tenggat_pelunasan = $request->input('tenggat_pelunasan');
        $rekapHutang->save();

        DB::commit();

        return redirect()->route('rekap_hutang')->with('success', 'Tenggat pelunasan berhasil diperbarui.');
    } catch (\Exception $e) {
        DB::rollBack();

        return redirect()->route('rekap_hutang')->with('error', 'Gagal memperbarui tenggat pelunasan.');
    }
}
}
