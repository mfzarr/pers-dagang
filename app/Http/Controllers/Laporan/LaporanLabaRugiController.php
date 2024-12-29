<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi\Penjualan;
use App\Models\Transaksi\Beban;
use App\Models\Masterdata\Coa;

class LaporanLabaRugiController extends Controller
{
    public function index(Request $request)
    {
        $id_perusahaan = auth()->user()->id_perusahaan;

        // Get date filters from request
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Fetch Pendapatan (Revenue) with optional date filtering
        $pendapatan = Coa::whereHas('kelompokakun', function ($query) {
            $query->where('kelompok_akun', '4');
        })
            ->where('id_perusahaan', $id_perusahaan)
            ->with(['penjualan' => function ($query) use ($startDate, $endDate) {
                if ($startDate && $endDate) {
                    $query->whereBetween('tgl_transaksi', [$startDate, $endDate]);
                }
            }])
            ->get();

        // Fetch HPP (Cost of Goods Sold) with Coa kode akun 5101 and optional date filtering
        $hpp = Coa::where('kode_akun', '5101')
            ->where('id_perusahaan', $id_perusahaan)
            ->with(['penjualan' => function ($query) use ($startDate, $endDate) {
                if ($startDate && $endDate) {
                    $query->whereBetween('tgl_transaksi', [$startDate, $endDate]);
                }
            }])
            ->get();

        // Sum HPP totals
        foreach ($hpp as $item) {
            $item->penjualan_sum_hpp = $item->penjualan->sum('hpp');
        }

        // Sum penjualan totals
        foreach ($pendapatan as $item) {
            $item->penjualan_sum_total = $item->penjualan->sum('total');
        }

        // Fetch Biaya (Expenses) grouped by coa with optional date filtering
        $biaya = Beban::with('coa')
            ->whereHas('coa.kelompokakun', function ($query) {
                $query->where('kelompok_akun', '5');
            })
            ->where('id_perusahaan', $id_perusahaan)
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                $query->whereBetween('tanggal', [$startDate, $endDate]);
            })
            ->get()
            ->groupBy('id_coa')
            ->map(function ($items, $id_coa) {
                $coa = $items->first()->coa;
                $totalHarga = $items->sum('harga');
                return [
                    'kode_akun' => $coa->kode_akun,
                    'nama_akun' => $coa->nama_akun,
                    'total_harga' => $totalHarga,
                ];
            });

        // Calculate totals
        $totalPendapatan = $pendapatan->sum('penjualan_sum_total');
        $totalHpp = $hpp->sum('penjualan_sum_hpp');
        $labakotor = $totalPendapatan - $totalHpp;
        $totalBiaya = $biaya->sum('total_harga');
        $labaRugi = $labakotor - $totalBiaya;

        return view('laporan.laba_rugi.index', compact('pendapatan', 'hpp', 'biaya', 'totalPendapatan', 'totalHpp', 'totalBiaya', 'labaRugi', 'labakotor'));
    }

    public function getLabaRugi(Request $request)
    {
        $id_perusahaan = auth()->user()->id_perusahaan;

        // Get date filters from request
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Fetch Pendapatan (Revenue) with optional date filtering
        $pendapatan = Coa::whereHas('kelompokakun', function ($query) {
            $query->where('kelompok_akun', '4');
        })
            ->where('id_perusahaan', $id_perusahaan)
            ->with(['penjualan' => function ($query) use ($startDate, $endDate) {
                if ($startDate && $endDate) {
                    $query->whereBetween('tgl_transaksi', [$startDate, $endDate]);
                }
            }])
            ->get();

        // Fetch HPP (Cost of Goods Sold) with Coa kode akun 5101 and optional date filtering
        $hpp = Coa::where('kode_akun', '5101')
            ->where('id_perusahaan', $id_perusahaan)
            ->with(['penjualan' => function ($query) use ($startDate, $endDate) {
                if ($startDate && $endDate) {
                    $query->whereBetween('tgl_transaksi', [$startDate, $endDate]);
                }
            }])
            ->get();

        // Sum HPP totals
        foreach ($hpp as $item) {
            $item->penjualan_sum_hpp = $item->penjualan->sum('hpp');
        }

        // Sum penjualan totals
        foreach ($pendapatan as $item) {
            $item->penjualan_sum_total = $item->penjualan->sum('total');
        }

        // Fetch Biaya (Expenses) grouped by coa with optional date filtering
        $biaya = Beban::with('coa')
            ->whereHas('coa.kelompokakun', function ($query) {
                $query->where('kelompok_akun', '5');
            })
            ->where('id_perusahaan', $id_perusahaan)
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                $query->whereBetween('tanggal', [$startDate, $endDate]);
            })
            ->get()
            ->groupBy('id_coa')
            ->map(function ($items, $id_coa) {
                $coa = $items->first()->coa;
                $totalHarga = $items->sum('harga');
                return [
                    'kode_akun' => $coa->kode_akun,
                    'nama_akun' => $coa->nama_akun,
                    'total_harga' => $totalHarga,
                ];
            });

        // Calculate totals
        $totalPendapatan = $pendapatan->sum('penjualan_sum_total');
        $totalHpp = $hpp->sum('penjualan_sum_hpp');
        $labakotor = $totalPendapatan - $totalHpp;
        $totalBiaya = $biaya->sum('total_harga');
        $labaRugi = $labakotor - $totalBiaya;
    

        return response()->json(['laba_rugi' => $labaRugi]);
    }
}