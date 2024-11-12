<?php

namespace App\Http\Controllers\Masterdata;

use App\Models\Masterdata\Jasadetail;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreJasadetailRequest;
use App\Http\Requests\UpdateJasadetailRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class JasadetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // 
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'detail' => 'required',
            'satuan' => 'required',
            'kategori' => 'required',
            'id_perusahaan' => 'required',
        ]);

        // Save data
        Jasadetail::create([
            'nama' => $request->nama,
            'detail' => $request->detail,
            'satuan' => $request->satuan,
            'kategori' => $request->kategori,
            'id_perusahaan' => $request->id_perusahaan,
        ]);

        return response()->json(['message' => 'User created successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Jasadetail $barang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Fetch the COA record by ID
        $barangs = Jasadetail::findOrFail($id);

        // Fetch the list of perusahaan for the dropdown
        $perusahaan = DB::table('perusahaan')->get();

        // Pass the data to the edit view
        // return view('masterdata.barang.edit', compact('barangs', 'kelompokAkun', 'perusahaan'));
        return response()->json($data = [
            'barangs' => $barangs,
            'perusahaan' => $perusahaan,
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_barang)
    {
        // Save data
        Jasadetail::where('id_barang', $id_barang)
        ->update([
            'nama' => $request->nama,
            'detail' => $request->detail,
            'satuan' => $request->satuan,
            'kategori' => $request->kategori,
            'id_perusahaan' => $request->id_perusahaan,
        ]);

        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $barang = Jasadetail::findOrFail($id);
        $barang->delete();

        return response()->json(['success' => true]);
    }
}
