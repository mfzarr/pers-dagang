<?php

namespace App\Http\Controllers\Laporan;

use Illuminate\Http\Request;
use App\Models\Masterdata\Coa;
use App\Models\Laporan\JurnalUmum;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class LaporanLabaRugiController extends Controller
{
    public function calculateLabaRugi($startDate, $endDate, $id_perusahaan = null)
    {
        if (!$id_perusahaan) {
            $id_perusahaan = auth()->user()->id_perusahaan;
        }

        // Get Pendapatan (Revenue) from neraca saldo
        $pendapatan = $this->getAccountsFromNeracaSaldo($id_perusahaan, '4', $startDate, $endDate);

        // Get Biaya (Expenses) from neraca saldo
        $biaya = $this->getAccountsFromNeracaSaldo($id_perusahaan, '5', $startDate, $endDate);

        $totalPendapatan = $pendapatan->sum('saldo');
        $totalBiaya = $biaya->sum('saldo');
        $labaRugi = $totalPendapatan - $totalBiaya;

        return [
            'pendapatan' => $pendapatan,
            'biaya' => $biaya,
            'totalPendapatan' => $totalPendapatan,
            'totalBiaya' => $totalBiaya,
            'labaRugi' => $labaRugi
        ];
    }

    private function getAccountsFromNeracaSaldo($id_perusahaan, $kelompok_akun, $startDate, $endDate)
    {
        return DB::table('coa')
            ->leftJoin('jurnal_umum', function($join) use ($startDate, $endDate) {
                $join->on('coa.id_coa', '=', 'jurnal_umum.id_coa')
                     ->whereBetween('jurnal_umum.tanggal_jurnal', [$startDate, $endDate]);
            })
            ->select(
                'coa.id_coa',
                'coa.kode_akun',
                'coa.nama_akun',
                DB::raw('COALESCE(coa.saldo_awal, 0) + 
                    CASE 
                        WHEN coa.kelompok_akun IN (1, 5) THEN COALESCE(SUM(jurnal_umum.debit), 0) - COALESCE(SUM(jurnal_umum.credit), 0)
                        ELSE COALESCE(SUM(jurnal_umum.credit), 0) - COALESCE(SUM(jurnal_umum.debit), 0)
                    END as saldo')
            )
            ->where('coa.kelompok_akun', $kelompok_akun)
            ->where('coa.id_perusahaan', $id_perusahaan)
            ->groupBy('coa.id_coa', 'coa.kode_akun', 'coa.nama_akun', 'coa.saldo_awal', 'coa.kelompok_akun')
            ->orderBy('coa.kode_akun')
            ->get();
    }

    public function index(Request $request)
    {
        $id_perusahaan = auth()->user()->id_perusahaan;
        
        // Get selected month or default to current month
        $selectedMonth = $request->input('bulan', date('Y-m'));
        $date = Carbon::createFromFormat('Y-m', $selectedMonth);
        
        // Get first and last day of selected month
        $startDate = $date->copy()->startOfMonth()->format('Y-m-d');
        $endDate = $date->copy()->endOfMonth()->format('Y-m-d');

        $calculations = $this->calculateLabaRugi($startDate, $endDate, $id_perusahaan);

        return view('laporan.laba_rugi.index', [
            'pendapatan' => $calculations['pendapatan'],
            'biaya' => $calculations['biaya'],
            'totalPendapatan' => $calculations['totalPendapatan'],
            'totalBiaya' => $calculations['totalBiaya'],
            'labaRugi' => $calculations['labaRugi'],
            'selectedMonth' => $selectedMonth
        ]);
    }
}
// use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;
// use App\Models\Transaksi\Penjualan;
// use App\Models\Transaksi\Beban;
// use App\Models\Masterdata\Coa;

// class LaporanLabaRugiController extends Controller
// {
//     public function index(Request $request)
//     {
//         $id_perusahaan = auth()->user()->id_perusahaan;

//         // Get date filters from request
//         $startDate = $request->input('start_date');
//         $endDate = $request->input('end_date');

//         // Fetch Pendapatan (Revenue) with optional date filtering
//         $pendapatan = Coa::whereHas('kelompokakun', function ($query) {
//             $query->where('kelompok_akun', '4');
//         })
//             ->where('id_perusahaan', $id_perusahaan)
//             ->with(['penjualan' => function ($query) use ($startDate, $endDate) {
//                 if ($startDate && $endDate) {
//                     $query->whereBetween('tgl_transaksi', [$startDate, $endDate]);
//                 }
//             }])
//             ->get();

//         // Fetch HPP (Cost of Goods Sold) with Coa kode akun 5101 and optional date filtering
//         $hpp = Coa::where('kode_akun', '5101')
//             ->where('id_perusahaan', $id_perusahaan)
//             ->with(['penjualan' => function ($query) use ($startDate, $endDate) {
//                 if ($startDate && $endDate) {
//                     $query->whereBetween('tgl_transaksi', [$startDate, $endDate]);
//                 }
//             }])
//             ->get();

//         // Sum HPP totals
//         foreach ($hpp as $item) {
//             $item->penjualan_sum_hpp = $item->penjualan->sum('hpp');
//         }

//         // Sum penjualan totals
//         foreach ($pendapatan as $item) {
//             $item->penjualan_sum_total = $item->penjualan->sum('total');
//         }

//         // Fetch Biaya (Expenses) grouped by coa with optional date filtering
//         $biaya = Beban::with('coa')
//             ->whereHas('coa.kelompokakun', function ($query) {
//                 $query->where('kelompok_akun', '5');
//             })
//             ->where('id_perusahaan', $id_perusahaan)
//             ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
//                 $query->whereBetween('tanggal', [$startDate, $endDate]);
//             })
//             ->get()
//             ->groupBy('id_coa')
//             ->map(function ($items, $id_coa) {
//                 $coa = $items->first()->coa;
//                 $totalHarga = $items->sum('harga');
//                 return [
//                     'kode_akun' => $coa->kode_akun,
//                     'nama_akun' => $coa->nama_akun,
//                     'total_harga' => $totalHarga,
//                 ];
//             });

//         // Calculate totals
//         $totalPendapatan = $pendapatan->sum('penjualan_sum_total');
//         $totalHpp = $hpp->sum('penjualan_sum_hpp');
//         $labakotor = $totalPendapatan - $totalHpp;
//         $totalBiaya = $biaya->sum('total_harga');
//         $labaRugi = $labakotor - $totalBiaya;

//         return view('laporan.laba_rugi.index', compact('pendapatan', 'hpp', 'biaya', 'totalPendapatan', 'totalHpp', 'totalBiaya', 'labaRugi', 'labakotor'));
//     }

//     public function getLabaRugi(Request $request)
//     {
//         $id_perusahaan = auth()->user()->id_perusahaan;

//         // Get date filters from request
//         $startDate = $request->input('start_date');
//         $endDate = $request->input('end_date');

//         // Fetch Pendapatan (Revenue) with optional date filtering
//         $pendapatan = Coa::whereHas('kelompokakun', function ($query) {
//             $query->where('kelompok_akun', '4');
//         })
//             ->where('id_perusahaan', $id_perusahaan)
//             ->with(['penjualan' => function ($query) use ($startDate, $endDate) {
//                 if ($startDate && $endDate) {
//                     $query->whereBetween('tgl_transaksi', [$startDate, $endDate]);
//                 }
//             }])
//             ->get();

//         // Fetch HPP (Cost of Goods Sold) with Coa kode akun 5101 and optional date filtering
//         $hpp = Coa::where('kode_akun', '5101')
//             ->where('id_perusahaan', $id_perusahaan)
//             ->with(['penjualan' => function ($query) use ($startDate, $endDate) {
//                 if ($startDate && $endDate) {
//                     $query->whereBetween('tgl_transaksi', [$startDate, $endDate]);
//                 }
//             }])
//             ->get();

//         // Sum HPP totals
//         foreach ($hpp as $item) {
//             $item->penjualan_sum_hpp = $item->penjualan->sum('hpp');
//         }

//         // Sum penjualan totals
//         foreach ($pendapatan as $item) {
//             $item->penjualan_sum_total = $item->penjualan->sum('total');
//         }

//         // Fetch Biaya (Expenses) grouped by coa with optional date filtering
//         $biaya = Beban::with('coa')
//             ->whereHas('coa.kelompokakun', function ($query) {
//                 $query->where('kelompok_akun', '5');
//             })
//             ->where('id_perusahaan', $id_perusahaan)
//             ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
//                 $query->whereBetween('tanggal', [$startDate, $endDate]);
//             })
//             ->get()
//             ->groupBy('id_coa')
//             ->map(function ($items, $id_coa) {
//                 $coa = $items->first()->coa;
//                 $totalHarga = $items->sum('harga');
//                 return [
//                     'kode_akun' => $coa->kode_akun,
//                     'nama_akun' => $coa->nama_akun,
//                     'total_harga' => $totalHarga,
//                 ];
//             });

//         // Calculate totals
//         $totalPendapatan = $pendapatan->sum('penjualan_sum_total');
//         $totalHpp = $hpp->sum('penjualan_sum_hpp');
//         $labakotor = $totalPendapatan - $totalHpp;
//         $totalBiaya = $biaya->sum('total_harga');
//         $labaRugi = $labakotor - $totalBiaya;
    

//         return response()->json(['laba_rugi' => $labaRugi]);
//     }
// }