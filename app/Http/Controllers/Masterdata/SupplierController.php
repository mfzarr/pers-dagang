<?php

namespace App\Http\Controllers\Masterdata;

use App\Http\Controllers\Controller;
use App\Models\Masterdata\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupplierController extends Controller
{
    public function index()
    {
        $id_perusahaan = Auth::user()->id_perusahaan;
        $suppliers = Supplier::where('id_perusahaan', $id_perusahaan)->get();
        return view('masterdata.supplier.index', compact('suppliers'));
    }

    public function create()
    {
        return view('masterdata.supplier.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|max:50',
            'alamat' => 'required|max:50',
            'no_telp' => 'required|max:50',
        ]);

        Supplier::create([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp,
            'id_perusahaan' => Auth::user()->id_perusahaan,
        ]);

        return redirect()->route('supplier.index')->with('success', 'Supplier created successfully.');
    }

    public function edit($id)
    {
        $supplier = Supplier::where('id_perusahaan', Auth::user()->id_perusahaan)
                            ->findOrFail($id);
        return view('masterdata.supplier.edit', compact('supplier'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|max:50',
            'alamat' => 'required|max:50',
            'no_telp' => 'required|max:50',
        ]);

        $supplier = Supplier::where('id_perusahaan', Auth::user()->id_perusahaan)
                            ->findOrFail($id);

        $supplier->update([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp,
        ]);

        return redirect()->route('supplier.index')->with('success', 'Supplier updated successfully.');
    }

    public function destroy($id)
    {
        $supplier = Supplier::where('id_perusahaan', Auth::user()->id_perusahaan)
                            ->findOrFail($id);
        $supplier->delete();

        return redirect()->route('supplier.index')->with('success', 'Supplier deleted successfully.');
    }
}
