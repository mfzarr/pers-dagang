<?php

namespace App\Http\Controllers\Masterdata;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCoaKelompokRequest;
use App\Http\Requests\UpdateCoaKelompokRequest; // Ensure this class exists in the specified namespace
use App\Models\Masterdata\Perusahaan;
use App\Models\Masterdata\CoaKelompok;

class CoaKelompokController extends Controller
{
    public function index()
    {
        $userPerusahaanId = auth()->user()->id_perusahaan;
    
        $coaKelompoks = CoaKelompok::where('id_perusahaan', $userPerusahaanId)->get();
    
        return view('masterdata.coa-kelompok.index', [
            'coaKelompoks' => $coaKelompoks,
            'table' => 'coa-kelompok'  // Define the table here
        ]);
    }
    

    /**
     * Store a newly created COA Kelompok in the database.
     */
    public function store(StoreCoaKelompokRequest $request)
    {
        $data = $request->validated();
        $data['id_perusahaan'] = auth()->user()->id_perusahaan;

        CoaKelompok::create($data);

        return response()->json([
            'message' => 'COA Kelompok successfully created!'
        ]);
    }

    /**
     * Show the form for editing the specified COA Kelompok record.
     */
    public function edit($id)
    {
        $userPerusahaanId = auth()->user()->id_perusahaan;
        $coaKelompok = CoaKelompok::where('id_coa_kelompok', $id)
                    ->where('id_perusahaan', $userPerusahaanId)
                    ->first();

        return view('masterdata.coa-kelompok.edit', [
            'coaKelompok' => $coaKelompok
        ]);
    }

    /**
     * Update the specified COA Kelompok in the database.
     */
    public function update(UpdateCoaKelompokRequest $request, $id)
    {
        $data = $request->validated();
        $data['id_perusahaan'] = auth()->user()->id_perusahaan;

        CoaKelompok::where('id_coa_kelompok', $id)
            ->where('id_perusahaan', $data['id_perusahaan'])
            ->update($data);

        return response()->json([
            'message' => 'COA Kelompok successfully updated!'
        ]);
    }

    /**
     * Remove the specified COA Kelompok from the database.
     */
    public function destroy($table, $id)
    {
        $userPerusahaanId = auth()->user()->id_perusahaan;
    
        // You need to adjust this based on your table and how you want to delete
        if ($table == 'coaKelompoks') {
            CoaKelompok::where('id_coa_kelompok', $id)
                ->where('id_perusahaan', $userPerusahaanId)
                ->delete();
        }
    
        return response()->json([
            'message' => 'Item deleted successfully'
        ]);
    }
    
}
