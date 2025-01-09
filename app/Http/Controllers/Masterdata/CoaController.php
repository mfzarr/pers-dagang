<?php

namespace App\Http\Controllers\Masterdata;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Masterdata\Coa;
use App\Models\Masterdata\CoaKelompok;
use Illuminate\Support\Facades\Auth;

class CoaController extends Controller
{
    /**
     * Display a listing of the COA.
     */
    public function index()
    {
        $id_perusahaan = Auth::user()->id_perusahaan;
        $coas = Coa::where('id_perusahaan', $id_perusahaan)->get();
        return view('masterdata.coa.index', compact('coas'));
    }

    /**
     * Store a newly created COA in the database.
     */
    public function create()
    {
        $id_perusahaan = Auth::user()->id_perusahaan;
        $kelompokakun = CoaKelompok::where('id_perusahaan', $id_perusahaan)->get();
        return view('masterdata.coa.create', compact('kelompokakun'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_akun' => 'required|numeric|digits_between:1,4|unique:coa,kode_akun,NULL,id,id_perusahaan,' . Auth::user()->id_perusahaan,
            'nama_akun' => 'required|string|max:255',
            'kelompok_akun' => 'required|integer|exists:coa_kelompok,id_kelompok_akun',
            'posisi_d_c' => 'required|string|max:255',
            'saldo_awal' => 'required|numeric',
            'status' => 'nullable|string',
        ]);
        
        Coa::create([
            'kode_akun' => $request->kode_akun,
            'nama_akun' => $request->nama_akun,
            'kelompok_akun' => $request->kelompok_akun,
            'posisi_d_c' => $request->posisi_d_c,
            'saldo_awal' => $request->saldo_awal,
            'id_perusahaan' => Auth::user()->id_perusahaan,
        ]);
        return redirect()->route('coa.index')->with('success', 'COA berhasil ditambahkan!');
    }


    /**
     * Show the form for editing the specified COA record.
     */
    public function edit($id)
    {
        $id_perusahaan = Auth::user()->id_perusahaan;
        $coas = Coa::where('id_coa', $id)->firstOrFail();
        $kelompokakun = CoaKelompok::where('id_perusahaan', $id_perusahaan)->get();
        return view('masterdata.coa.edit', compact('coas', 'kelompokakun'));
    }


    /**
     * Update the specified COA record.
     */
    public function update(Request $request, $id)
    {
        $coa = Coa::where('id_coa', $id)->firstOrFail();

        $request->validate([
            'kode_akun' => 'required|numeric|digits_between:1,4',
            'nama_akun' => 'required|string|max:255',
            'kelompok_akun' => 'required|integer|exists:coa_kelompok,id_kelompok_akun',
            'posisi_d_c' => 'required|string|max:255',
            'saldo_awal' => 'required|numeric',
        ]);

        $coa->update([
            'kode_akun' => $request->kode_akun,
            'nama_akun' => $request->nama_akun,
            'kelompok_akun' => $request->kelompok_akun,
            'posisi_d_c' => $request->posisi_d_c,
            'saldo_awal' => $request->saldo_awal,
        ]);

        return redirect()->route('coa.index')->with('success', 'COA berhasil diupdate!');
    }


    // Delete COA ketika tidak ada jurnal yang terkait
    public function destroy($id)
    {
        $coa = Coa::where('id_perusahaan', Auth::user()->id_perusahaan)->findOrFail($id);
    
        // Check if there are any related journal entries
        if ($coa->jurnalUmums()->exists()) {
            return redirect()->route('coa.index')->with('error', 'COA tidak bisa dihapus karena berhubungan dengan jurnal!');
        }
    
        $coa->delete();
    
        return redirect()->route('coa.index')->with('success', 'COA berhasil dihapus!');
    }
    
    // Delete COA Bebas
    // public function destroy($id)
    // {
    //     $coa = Coa::where('id_perusahaan', Auth::user()->id_perusahaan)->findOrFail($id);
    //     $coa->delete();

    //     return redirect()->route('coa.index')->with('success', 'COA berhasil dihapus!');
    // }
}
