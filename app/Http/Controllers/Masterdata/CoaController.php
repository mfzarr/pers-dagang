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
            ->where('coa.id_perusahaan', $userPerusahaanId)
            ->select('coa.*', 'perusahaan.nama')
            ->get();

        $kelompokAkun = CoaKelompok::all();
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
        $coas = Coa::where('id_coa', $id)
                    ->where('id_perusahaan', $userPerusahaanId)
                    ->firstOrFail();

        $kelompokAkun = CoaKelompok::all();
        $perusahaan = Perusahaan::all();

        return response()->json([
            'coas' => $coas,
            'kelompokAkun' => $kelompokAkun,
            'perusahaan' => $perusahaan
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
