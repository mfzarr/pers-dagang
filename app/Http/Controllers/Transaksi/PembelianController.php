<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;
use App\Models\Transaksi\Pembelian;
use App\Models\Masterdata\Supplier;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class PembelianController extends Controller
{
    /**
     * Display a listing of all Pembelian filtered by the authenticated user's company.
     */
    public function index()
    {
        // Get only records for the authenticated user's company and load the supplier relation
        $id_perusahaan = Auth::user()->id_perusahaan;
        $pembelian = Pembelian::with(['pembelianDetails', 'supplierRelation'])
            ->where('id_perusahaan', $id_perusahaan)
            ->get();

        return view('transaksi.pembelian.index', compact('pembelian'));
    }


    /**
     * Show the form for creating a new Pembelian.
     */
    public function create()
    {
        $id_perusahaan = Auth::user()->id_perusahaan;

        // Fetch all suppliers and barang for the dropdowns, filtered by company
        $suppliers = Supplier::where('id_perusahaan', $id_perusahaan)->get();
        $barang = Produk::where('id_perusahaan', $id_perusahaan)->get();

        return view('transaksi.pembelian.create', compact('suppliers', 'barang'));
    }

    /**
     * Store a newly created Pembelian in the database.
     */
    public function store(Request $request)
    {
        // Validate input data
        $request->validate([
            'tanggal' => 'required|date',
            'supplier' => 'required|exists:supplier,id_supplier',
            'tipe_pembayaran' => 'required|in:tunai,kredit',
            'barang' => 'required|array',
            'barang.*.id_barang' => 'required|exists:barang,id_barang',
            'barang.*.qty' => 'required|integer|min:1',
            'barang.*.harga' => 'required|numeric|min:0',
            'barang.*.dibayar' => 'required|numeric|min:0'
        ]);

        // Create the Pembelian record with id_perusahaan
        $pembelian = Pembelian::create([
            'tanggal_pembelian' => $request->tanggal,
            'supplier' => $request->supplier,
            'tipe_pembayaran' => $request->tipe_pembayaran,
            'id_perusahaan' => Auth::user()->id_perusahaan,
        ]);

        // Calculate totals and store each PembelianDetail entry
        $total = 0;
        $total_dibayar = 0;

        foreach ($request->barang as $item) {
            $subtotal = $item['qty'] * $item['harga'];
            $total += $subtotal;
            $total_dibayar += $item['dibayar'];

            // Save each detail row to PembelianDetail without including sub_total_harga
            $pembelian->pembelianDetails()->create([
                'id_barang' => $item['id_barang'],
                'qty' => $item['qty'],
                'harga' => $item['harga'],
                'dibayar' => $item['dibayar'] // Do not set 'sub_total_harga' explicitly
            ]);
        }

        // Update Pembelian with totals
        $pembelian->update([
            'total' => $total,
            'total_dibayar' => $total_dibayar
        ]);

        return redirect()->route('pembelian.index')->with('success', 'Pembelian created successfully.');
    }


    /**
     * Remove the specified Pembelian from the database.
     */
    public function destroy($id)
    {
        $id_perusahaan = Auth::user()->id_perusahaan;
        $pembelian = Pembelian::where('id', $id)
            ->where('id_perusahaan', $id_perusahaan)
            ->firstOrFail();

        $pembelian->delete();

        return redirect()->route('pembelian.index')->with('success', 'Pembelian deleted successfully.');
    }
}
