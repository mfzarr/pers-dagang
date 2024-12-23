<?php

namespace App\Http\Controllers\Masterdata;

use App\Http\Controllers\Controller;
use App\Models\Masterdata\Produk;
use App\Models\Masterdata\Kategori_barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $id_perusahaan = Auth::user()->id_perusahaan;
        $produk = Produk::where('id_perusahaan', $id_perusahaan)->get();
        return view('masterdata.produk.index', compact('produk'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $id_perusahaan = Auth::user()->id_perusahaan;
        $kategori_barang = Kategori_barang::where('id_perusahaan', $id_perusahaan)->get();
        return view('masterdata.produk.create', compact('kategori_barang'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|max:255',
            'id_kategori_barang' => 'required|exists:kategori_barang,id_kategori_barang',            'stok' => 'required|integer',
            'harga' => 'required|integer',
            'hpp' => 'required|integer',
            'status' => 'required',
        ]);

        Produk::create([
            'nama' => $request->nama,
            'id_kategori_barang' => $request->id_kategori_barang, // Kesalahan di sini
            'stok' => $request->stok,
            'harga' => $request->harga,
            'hpp' => $request->hpp,
            'status' => $request->status,
            'id_perusahaan' => Auth::user()->id_perusahaan,
        ]);
        

        return redirect()->route('produk.index')->with('success', 'Produk created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Produk $produk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $id_perusahaan = Auth::user()->id_perusahaan;
        $produk = Produk::where('id_perusahaan', $id_perusahaan)->findOrFail($id);
        $kategori_barang = Kategori_barang::where('id_perusahaan', $id_perusahaan)->get();
        return view('masterdata.produk.edit', compact('produk', 'kategori_barang'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Produk $produk)
    {
        $request->validate([
            'nama' => 'required|max:255',
            'id_kategori_barang' => 'required|exists:kategori_barang,id_kategori_barang',
            'stok' => 'required|integer',
            'harga' => 'required|integer',
            'hpp' => 'required|integer',
            'status' => 'required',
        ]);

        //konversi input
        $stok = str_replace('.', '', $request->stok);
        $harga = str_replace('.', '', $request->harga);
        $hpp = str_replace('.', '', $request->hpp);

        $produk->update([
            'nama' => $request->nama,
            'id_kategori_barang' => $request->id_kategori_barang,
            'stok' => $stok,
            'harga' => $harga,
            'hpp' => $hpp,
            'status' => $request->status,
        ]);

        return redirect()->route('produk.index')->with('success', 'Produk updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $produk = Produk::where('id_perusahaan', Auth::user()->id_perusahaan)->findOrFail($id);
        $produk->delete();

        return redirect()->route('produk.index')->with('success', 'Produk deleted successfully.');
    }
}
