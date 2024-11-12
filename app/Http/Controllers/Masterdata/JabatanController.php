<?php


namespace App\Http\Controllers\Masterdata;

use App\Http\Controllers\Controller;
use App\Models\Masterdata\Jabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JabatanController extends Controller
{
    public function index()
    {
        $id_perusahaan = Auth::user()->id_perusahaan;
        $jabatans = Jabatan::where('id_perusahaan', $id_perusahaan)->get();
        return view('masterdata.jabatan.index', compact('jabatans'));
    }

    public function create()
    {
        return view('masterdata.jabatan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|max:255',
            'asuransi' => 'nullable|integer',
            'tarif_tetap' => 'nullable|integer',
            'tarif_tidak_tetap' => 'nullable|integer',
        ]);

        Jabatan::create([
            'nama' => $request->nama,
            'asuransi' => $request->asuransi,
            'tarif_tetap' => $request->tarif_tetap,
            'tarif_tidak_tetap' => $request->tarif_tidak_tetap,
            'id_perusahaan' => Auth::user()->id_perusahaan,
        ]);

        return redirect()->route('jabatan.index')->with('success', 'Jabatan created successfully.');
    }

    public function edit($id)
    {
        $jabatan = Jabatan::where('id_perusahaan', Auth::user()->id_perusahaan)
            ->findOrFail($id);
        return view('masterdata.jabatan.edit', compact('jabatan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|max:255',
            'asuransi' => 'nullable|integer',
            'tarif_tetap' => 'nullable|integer',
            'tarif_tidak_tetap' => 'nullable|integer',
        ]);

        $jabatan = Jabatan::where('id_perusahaan', Auth::user()->id_perusahaan)
            ->findOrFail($id);

        // Update with specific fields
        $jabatan->update([
            'nama' => $request->nama,
            'asuransi' => $request->asuransi,
            'tarif_tetap' => $request->tarif_tetap,
            'tarif_tidak_tetap' => $request->tarif_tidak_tetap,
        ]);

        return redirect()->route('jabatan.index')->with('success', 'Jabatan updated successfully.');
    }

    public function destroy($id)
    {
        $jabatan = Jabatan::where('id_perusahaan', Auth::user()->id_perusahaan)
            ->findOrFail($id);
        $jabatan->delete();

        return redirect()->route('jabatan.index')->with('success', 'Jabatan deleted successfully.');
    }
}
