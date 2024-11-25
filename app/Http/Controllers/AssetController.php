<?php

namespace App\Http\Controllers;

use App\Models\Masterdata\Asset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssetController extends Controller
{
    public function index()
    {
        $id_perusahaan = Auth::user()->id_perusahaan;
        $assets = Asset::where('id_perusahaan', $id_perusahaan)->get();
        return view('masterdata.aset.index', compact('assets'));
    }

    public function create()
    {
        return view('masterdata.aset.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_asset' => 'required|max:255',
            'harga_perolehan' => 'nullable|string',
            'nilai_sisa' => 'nullable|string',
            'masa_manfaat' => 'required|integer|min:1',
        ]);

        $harga_perolehan = str_replace('.', '', $request->harga_perolehan);
        $nilai_sisa = str_replace('.', '', $request->nilai_sisa);

        Asset::create([
            'nama_asset' => $request->nama_asset,
            'harga_perolehan' => $harga_perolehan,
            'nilai_sisa' => $nilai_sisa,
            'masa_manfaat' => $request->masa_manfaat,
            'id_perusahaan' => Auth::user()->id_perusahaan,
        ]);

        return redirect()->route('aset.index')->with('success', 'Asset created successfully.');
    }
    public function show(Asset $asset)
    {
        // Use the model's helper methods for calculations
        $penyusutan_per_tahun = $asset->depreciation_per_year;
        $schedule = $asset->calculateDepreciationSchedule();

        // Calculate total depreciation and current book value
        $total_depreciation = collect($schedule)->sum('biaya_penyusutan');
        $current_book_value = collect($schedule)->last()['nilai_buku'] ?? $asset->harga_perolehan;

        return view('aset.show', [
            'asset' => $asset,
            'penyusutan_per_tahun' => $penyusutan_per_tahun,
            'total_depreciation' => $total_depreciation,
            'current_book_value' => $current_book_value,
        ]);
    }
   public function edit($id)
    {
       $asset = Asset::findOrFail($id);
        return view('masterdata.aset.edit', compact('asset'));
    }

    public function update(Request $request,$id)
    {
        $request->validate([
            'nama_asset' => 'required|max:255',
            'harga_perolehan' => 'nullable|string',
            'nilai_sisa' => 'nullable|string',
            'masa_manfaat' => 'required|integer|min:1',
        ]);

        $aset = Asset::findOrFail($id);

        $harga_perolehan = str_replace('.', '', $request->harga_perolehan);
        $nilai_sisa = str_replace('.', '', $request->nilai_sisa);

        $aset->update([
            'nama_asset' => $request->nama_asset,
            'harga_perolehan' => $harga_perolehan,
            'nilai_sisa' => $nilai_sisa,
            'masa_manfaat' => $request->masa_manfaat,
        ]);

        return redirect()->route('aset.index')->with('success', 'Asset updated successfully.');
    }

    public function destroy(Asset $asset)
    {
        $asset->delete();
        return redirect()->route('aset.index')->with('success', 'Asset deleted successfully.');
    }

    public function calculateDepreciation(Asset $aset)
    {
        $schedule = $aset->calculateDepreciationSchedule();
    
        return view('masterdata.aset.depreciation', [
            'asset' => $aset, // Pastikan variabel 'asset' dikirim ke view
            'depreciation_schedule' => $schedule,
        ]);
    }
    
}
