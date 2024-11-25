<?php

namespace App\Http\Controllers\Masterdata;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCoaRequest;
use App\Http\Requests\UpdateCoaRequest;
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
    
        // Ambil data COA dengan join ke CoaKelompok
        $coas = Coa::join('coa_kelompok', 'coa.kelompok_akun', '=', 'coa_kelompok.kelompok_akun')
            ->where('coa.id_perusahaan', $id_perusahaan)
            ->select('coa.*', 'coa_kelompok.nama_kelompok_akun')
            ->get();
    
        // Ambil seluruh data kelompok akun
        $kelompokAkun = CoaKelompok::select('kelompok_akun', 'nama_kelompok_akun')->get();
    
        return view('masterdata.coa.index', [
            'coas' => $coas,
            'kelompokAkun' => $kelompokAkun,
            'table' => 'coa',
        ]);
    }
    
    /**
     * Store a newly created COA in the database.
     */
    public function create()
    {
        $kelompokAkun = CoaKelompok::select('kelompok_akun', 'nama_kelompok_akun')->get();
        return view('masterdata.coa.create', [
            'kelompokAkun' => $kelompokAkun,
        ]);
    }

    public function store(StoreCoaRequest $request)
    {
        $request->validated([
            'kode' => 'required|numeric|max:4',
            'nama_akun' => 'required|string|max:255',
            'kelompok_akun' => 'required|integer|max:1',
            'posisi_d_c' => 'required|string|max:255',
            'saldo_awal'=>'required|numeric|max:255',
        ]);
        Coa::create([
            'kode' => $request->kode,
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
        // Use id_coa as the primary key
        $coa = Coa::where('id_coa', $id)->firstOrFail();
        $kelompokAkun = CoaKelompok::select('kelompok_akun', 'nama_kelompok_akun')->get();
        return view('masterdata.coa.edit', [
            'coa' => $coa,
            'kelompokAkun' => $kelompokAkun,
        ]);
    }
    

    /**
     * Update the specified COA record.
     */
    public function update(Request $request, $id)
    {
        $coa = Coa::where('id_coa', $id)->firstOrFail();
    
        $request->validate([
            'kode' => 'required|numeric|digits_between:1,4',
            'nama_akun' => 'required|string|max:255',
            'kelompok_akun' => 'required|integer|max:1',
            'posisi_d_c' => 'required|string|max:255',
            'saldo_awal' => 'required|numeric|max:9999999999',
        ]);
    
        $coa->update([
            'kode' => $request->kode,
            'nama_akun' => $request->nama_akun,
            'kelompok_akun' => $request->kelompok_akun,
            'posisi_d_c' => $request->posisi_d_c,
            'saldo_awal' => $request->saldo_awal,
        ]);
    
        return redirect()->route('coa.index')->with('success', 'COA berhasil diupdate!');
    }
    

    /**
     * Remove the specified COA record.
     */
    public function destroy($id)
    {
        $coa = Coa::findOrFail($id);
        $coa->delete();
        return redirect()->route('coa.index')->with('success', 'COA berhasil dihapus!');
    }
}