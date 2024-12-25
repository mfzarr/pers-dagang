<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;
use App\Models\Transaksi\Beban;
use App\Models\Masterdata\Coa;
use App\Models\Laporan\JurnalUmum;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class BebanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $id_perusahaan = auth()->user()->id_perusahaan;
        $beban = Beban::with('coa:id_coa,nama_akun,kode_akun')
                  ->where('id_perusahaan', $id_perusahaan)->get();
        return view('transaksi.beban.index', compact('beban'));
        // Use paginate() and fetch `kode_akun` from the related Coa model
        // $beban = Beban::with('coa:id_coa,nama_akun,kode_akun')->paginate(10); // Adjust the items per page as needed
        // return view('transaksi.beban.index', compact('beban'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $id_perusahaan = auth()->user()->id_perusahaan;
        $coa = Coa::whereHas('kelompokakun', function ($query) {
            $query->where('kelompok_akun', '5');
        })->where('id_perusahaan', $id_perusahaan)
          ->where('nama_akun', 'LIKE', '%beban%')
          ->get();
        return view('transaksi.beban.create', compact('coa'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'nama_beban' => 'required|string|max:255',
            'harga' => 'required|integer',
            'tanggal' => 'required|date',
            'id_coa' => 'required|exists:coa,id_coa',
            'id_perusahaan' => 'required|exists:perusahaan,id_perusahaan',
        ]);

        // Create Beban (expense record)
        $beban = Beban::create($request->all());

        // After successfully creating the Beban record, create the corresponding journal entries
        $this->createJournalForBeban($beban);

        return redirect()->route('beban.index')->with('success', 'Beban berhasil ditambahkan.');
    }

    /**
     * Create the journal entries for the Beban transaction.
     */
    protected function createJournalForBeban(Beban $beban)
    {
        $perusahaanId = $beban->id_perusahaan;

        // Get the COA (Chart of Accounts) for relevant accounts
        $coaBeban = Coa::find($beban->id_coa); // Expense account
        $coaKas = Coa::where('kode_akun', '1101')->first(); // Example: Cash account, assuming '1' is the cash account ID

        $transactionId = Str::uuid(); // Generate a unique transaction ID

        // Prepare the transaction entries for the journal
        $transactionData = [
            'tanggal_jurnal' => $beban->tanggal,
            'transaction_id' => $transactionId,
            'entries' => [
                [
                    'id_coa' => $coaBeban->id_coa,
                    'nama_akun' => $coaBeban->nama_akun,
                    'kode_akun' => $coaBeban->kode_akun,
                    'debit' => $beban->harga, // Debit the expense account (beban)
                    'credit' => null, // No credit here
                    'transaction_id' => $transactionId, // Reference the same transaction ID
                ],
                [
                    'id_coa' => $coaKas->id_coa,
                    'nama_akun' => $coaKas->nama_akun,
                    'kode_akun' => $coaKas->kode_akun,
                    'debit' => null, // No debit here
                    'credit' => $beban->harga, // Credit the cash account (assuming cash payment)
                    'transaction_id' => $transactionId, // Reference the same transaction ID
                ]
            ]
        ];

        // Create journal entries for this expense transaction
        JurnalUmum::createFromTransaction($transactionData, $perusahaanId);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $id_perusahaan = Auth::user()->id_perusahaan;
        $beban = Beban::where('id_perusahaan', $id_perusahaan)
        ->findOrFail($id);
        $coa = Coa::whereHas('kelompokakun', function ($query) {
            $query->where('kelompok_akun', '5');
        })->where('id_perusahaan', $id_perusahaan)
          ->where('nama_akun', 'LIKE', '%beban%')
          ->get();

        return view('transaksi.beban.edit', compact('beban', 'coa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $request->validate([
            'nama_beban' => 'required|string|max:255',
            'harga' => 'required|integer',
            'tanggal' => 'required|date',
            'id_coa' => 'required|exists:coa,id_coa',
        ]);

        // Update the Beban record
        $beban = Beban::findOrFail($id);
        $beban->update($request->all());

        return redirect()->route('beban.index')->with('success', 'Beban berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Find the Beban record and delete it
        $beban = Beban::findOrFail($id);
        $beban->delete();

        return redirect()->route('beban.index')->with('success', 'Beban berhasil dihapus.');
    }
}
