<?php

namespace App\Http\Controllers\Laporan;

use Illuminate\Http\Request;
use App\Models\Masterdata\Coa;
use App\Models\Laporan\JurnalUmum;
use Carbon\Carbon;
use App\Http\Controllers\Controller;

class LaporanPerubahanModalController extends Controller
{
    public function index(Request $request)
    {
        $id_perusahaan = auth()->user()->id_perusahaan;
        $namaPerusahaan = auth()->user()->perusahaan->nama;

        $selectedDate = $request->input('tanggal', date('Y-m-d'));
        $date = Carbon::parse($selectedDate);
        
        $startOfMonth = $date->copy()->startOfMonth()->format('Y-m-d');
        $endOfMonth = $date->copy()->endOfMonth()->format('Y-m-d');
        $namaBulan = $date->format('F Y');

        try {
            // Get Modal Awal from COA
            $modalCoa = Coa::where('id_perusahaan', $id_perusahaan)
                ->whereHas('kelompokakun', function($q) {
                    $q->where('kelompok_akun', '3');
                })
                ->where('nama_akun', 'like', '%modal%')
                ->first();

            if (!$modalCoa) {
                throw new \Exception('Akun modal tidak ditemukan');
            }

            $modalAwal = $modalCoa->saldo_awal ?? 0;

            // Get Laba/Rugi using the shared calculation method
            $labaRugiController = new LaporanLabaRugiController();
            $calculations = $labaRugiController->calculateLabaRugi($startOfMonth, $endOfMonth, $id_perusahaan);
            
            $laba = $calculations['labaRugi'];
            $prive = 0; // Set to 0 since not implemented yet
            
            $laba_prive = $laba - $prive;
            $modal_akhir = $modalAwal + $laba_prive;

            return view('laporan.perubahanmodal.index', compact(
                'namaPerusahaan',
                'namaBulan',
                'modalAwal',
                'laba',
                'prive',
                'laba_prive',
                'modal_akhir',
                'startOfMonth',
                'endOfMonth'
            ));

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function calculateModalAkhir($startOfMonth, $endOfMonth, $id_perusahaan)
{
    try {
        // Get Modal Awal from COA
        $modalCoa = Coa::where('id_perusahaan', $id_perusahaan)
            ->whereHas('kelompokakun', function($q) {
                $q->where('kelompok_akun', '3');
            })
            ->where('nama_akun', 'like', '%modal%')
            ->first();

        if (!$modalCoa) {
            throw new \Exception('Akun modal tidak ditemukan');
        }

        $modalAwal = $modalCoa->saldo_awal ?? 0;

        // Get Laba/Rugi using the shared calculation method
        $labaRugiController = new LaporanLabaRugiController();
        $calculations = $labaRugiController->calculateLabaRugi($startOfMonth, $endOfMonth, $id_perusahaan);
        
        $laba = $calculations['labaRugi'];
        $prive = 0; // Set to 0 since not implemented yet
        
        $laba_prive = $laba - $prive;
        $modal_akhir = $modalAwal + $laba_prive;

        return $modal_akhir;
    } catch (\Exception $e) {
        throw new \Exception('Error calculating modal akhir: ' . $e->getMessage());
    }
}
}