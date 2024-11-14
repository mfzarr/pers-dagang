<?php

namespace App\Http\Controllers\Masterdata;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCoaRequest;
use App\Http\Requests\UpdateCoaRequest;
use App\Models\Masterdata\Coa;
use App\Models\Masterdata\CoaKelompok;
use App\Models\Masterdata\Perusahaan;

class CoaController extends Controller
{
    /**
     * Display a listing of the COA.
     */
    public function index()
    {
        $userPerusahaanId = auth()->user()->id_perusahaan;
    
        $coas = Coa::join('perusahaan', 'coa.id_perusahaan', '=', 'perusahaan.id_perusahaan')
            ->join('coa_kelompok', 'coa.kelompok_akun', '=', 'coa_kelompok.kelompok_akun')
            ->where('coa.id_perusahaan', $userPerusahaanId)
            ->select('coa.*', 'perusahaan.nama', 'coa_kelompok.nama_kelompok_akun')
            ->get();
    
            $kelompokAkun = CoaKelompok::where('kelompok_akun', '>=', 100)->get();
            $perusahaan = Perusahaan::all();
    
        return view('masterdata.coa.index', [
            'coas' => $coas,
            'kelompokAkun' => $kelompokAkun,
            'perusahaan' => $perusahaan,
            'table' => 'coa'
        ]);
    }
    

    /**
     * Store a newly created COA in the database.
     */
    public function store(StoreCoaRequest $request)
    {
        $data = $request->validated();
        $data['id_perusahaan'] = auth()->user()->id_perusahaan;

        Coa::create($data);

        return response()->json([
            'message' => 'COA successfully created!'
        ]);
    }

    /**
     * Show the form for editing the specified COA record.
     */
    public function edit($id)
    {
        $userPerusahaanId = auth()->user()->id_perusahaan;
        $coa = Coa::where('id_coa', $id)
                  ->where('id_perusahaan', $userPerusahaanId)
                  ->firstOrFail();
    
        return response()->json([
            'coas' => $coa
        ]);
    }
    

    /**
     * Update the specified COA record.
     */
    public function update(UpdateCoaRequest $request, $id)
    {
        $userPerusahaanId = auth()->user()->id_perusahaan;
        $coa = Coa::where('id_coa', $id)
                  ->where('id_perusahaan', $userPerusahaanId)
                  ->firstOrFail();

        $data = $request->validated();
        $data['id_perusahaan'] = $userPerusahaanId;

        $coa->update($data);

        return response()->json([
            'message' => 'COA successfully updated!'
        ]);
    }

    /**
     * Remove the specified COA record.
     */
    public function destroy($id)
    {
        $userPerusahaanId = auth()->user()->id_perusahaan;
        $coa = Coa::where('id_coa', $id)
                  ->where('id_perusahaan', $userPerusahaanId)
                  ->firstOrFail();

        $coa->delete();

        return response()->json([
            'message' => 'COA successfully deleted!'
        ]);
    }
}
