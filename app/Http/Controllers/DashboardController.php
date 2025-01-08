<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi\Penjualan;
use App\Models\Transaksi\PenjualanDetail;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $totalPendapatan = Penjualan::whereMonth('tgl_transaksi', $currentMonth)
            ->whereYear('tgl_transaksi', $currentYear)
            ->sum('total');

        $totalKuantitas = PenjualanDetail::whereHas('penjualan', function ($query) use ($currentMonth, $currentYear) {
            $query->whereMonth('tgl_transaksi', $currentMonth)
                  ->whereYear('tgl_transaksi', $currentYear);
        })->sum('kuantitas');

        $totalSales = Penjualan::whereMonth('tgl_transaksi', $currentMonth)
            ->whereYear('tgl_transaksi', $currentYear)
            ->sum(\DB::raw('total - hpp'));
        
        return view('dashboard', compact('totalPendapatan', 'totalKuantitas', 'totalSales'));
    }
}