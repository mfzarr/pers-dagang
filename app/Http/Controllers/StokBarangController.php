<?php

namespace App\Http\Controllers;

use App\Models\stokBarang;
use App\Http\Requests\StorestokBarangRequest;
use App\Http\Requests\UpdatestokBarangRequest;
use App\Models\Masterdata\Barang;
use App\Models\Masterdata\Perusahaan;
use App\Models\Masterdata\Supplier;
use App\Models\Transaksi\Pembelian;
use App\Models\Transaksi\Pembeliandetail;
use Illuminate\Support\Facades\DB;

class StokBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lunas = Pembelian::where('status', 'lunas')->get();

        $stokBarangs = stokBarang::whereIn('id_pembelian_barang', $lunas->pluck('id_pembelian'))->get();

        foreach($stokBarangs as $stokBarang) {
            $barangs = Barang::where('id_barang', $stokBarang->nama_barang)->first();
            $pembelianDetials = Pembeliandetail::where('id_pembelian_detail', $stokBarang->nama_barang)->first();
            $pembelians = Pembelian::where('id_pembelian', $pembelianDetials->id_pembelian)->first();
            $perusahaan = Perusahaan::where('id_perusahaan', $pembelians->id_perusahaan)->first();
            $supplier = Supplier::where('id_supplier', $pembelians->id_supplier)->first();

            $stokBarang->nama_barang = $barangs->nama;
            $stokBarang->kategori = $barangs->kategori;
            $stokBarang->detail = $barangs->detail;
            $stokBarang->satuan = $barangs->satuan;
            $stokBarang->perusahaan = $perusahaan->nama;
            $stokBarang->supplier = $supplier->nama;
            $stokBarang->pengeluaran = 0; 
        }

        return view('masterdata/stokBarang/index', 
    [
        'table' => 'Stok Barang',
        'barangs' => $stokBarangs,
    ]);
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
    public function store(StorestokBarangRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(stokBarang $stokBarang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(stokBarang $stokBarang)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatestokBarangRequest $request, stokBarang $stokBarang)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(stokBarang $stokBarang)
    {
        //
    }
}
