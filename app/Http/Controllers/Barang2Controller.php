<?php

namespace App\Http\Controllers;

use App\Models\Barang2;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Barang2Controller extends Controller
{
    public function index()
    {
        $id_perusahaan = Auth::user()->id_perusahaan;
        $barangs = Barang2::where('id_perusahaan', $id_perusahaan)->get();
        return view('barang2.index', compact('barangs'));
    }

    public function create()
    {
        return view('barang2.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|max:50',
            'detail' => 'required|max:255',
            'satuan' => 'required|max:50',
            'harga_jual' => 'required|numeric',
            'HPP' => 'required|numeric',
        ]);

        Barang2::create([
            'nama' => $request->nama,
            'detail' => $request->detail,
            'satuan' => $request->satuan,
            'harga_jual' => $request->harga_jual,
            'HPP' => $request->HPP,
            'id_perusahaan' => Auth::user()->id_perusahaan,
        ]);

        return redirect()->route('barang2.index')->with('success', 'Barang created successfully.');
    }

    public function edit($id)
    {
        $barang = Barang2::findOrFail($id);
        return view('barang2.edit', compact('barang'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|max:50',
            'detail' => 'required|max:255',
            'satuan' => 'required|max:50',
            'harga_jual' => 'required|numeric',
            'HPP' => 'required|numeric',
        ]);

        $barang = Barang2::findOrFail($id);
        $barang->update([
            'nama' => $request->nama,
            'detail' => $request->detail,
            'satuan' => $request->satuan,
            'harga_jual' => $request->harga_jual,
            'HPP' => $request->HPP,
        ]);

        return redirect()->route('barang2.index')->with('success', 'Barang updated successfully.');
    }

    public function destroy($id)
    {
        $barang = Barang2::findOrFail($id);
        $barang->delete();

        return redirect()->route('barang2.index')->with('success', 'Barang deleted successfully.');
    }
}
