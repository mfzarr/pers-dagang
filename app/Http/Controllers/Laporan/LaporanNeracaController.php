<?php

namespace App\Http\Controllers\Laporan;

use Illuminate\Http\Request;
use App\Models\Masterdata\Coa;
use App\Models\Laporan\JurnalUmum;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Laporan\LaporanLabaRugiController;

class LaporanNeracaController extends Controller
{
    protected $laporanLabaRugiController;

    public function __construct(LaporanLabaRugiController $laporanLabaRugiController)
    {
        $this->laporanLabaRugiController = $laporanLabaRugiController;
    }

    public function index(Request $request)
    {
        $id_perusahaan = auth()->user()->id_perusahaan;
        $tanggal = $request->input('tanggal', date('Y-m-d'));
        $namaBulan = \Carbon\Carbon::parse($tanggal)->isoFormat('MMMM Y');
        $namaPerusahaan = auth()->user()->perusahaan->nama;
    
        // Get laba rugi
        $labaRugiResponse = $this->laporanLabaRugiController->getLabaRugi($request);
        $labaRugiData = json_decode($labaRugiResponse->getContent(), true);
        $labaRugi = $labaRugiData['labaRugi'] ?? 0;
    
    
        // Get Current Assets (Aktiva Lancar)
        $currentAssets = $this->getCurrentAssets($id_perusahaan, $tanggal);
        $totalCurrentAssets = $currentAssets->sum('ending_balance');
    
        // Get Fixed Assets (Aktiva Tetap)
        $fixedAssets = $this->getFixedAssets($id_perusahaan, $tanggal);
        $totalFixedAssets = collect($fixedAssets)->sum('net_value');
    
        // Get Current Liabilities (Hutang Jangka Pendek)
        $currentLiabilities = $this->getCurrentLiabilities($id_perusahaan, $tanggal);
        $totalCurrentLiabilities = $currentLiabilities->sum('ending_balance');
    
        // Get Equity (Modal)
        $equity = $this->getEquity($id_perusahaan, $tanggal, $labaRugi);
        $totalEquity = $equity->sum('ending_balance');
    
        // Calculate total assets and total liabilities + equity
        $totalAssets = $totalCurrentAssets + $totalFixedAssets;
        $totalLiabilitiesEquity = $totalCurrentLiabilities + $totalEquity;
    
        return view('laporan.neraca.index', compact(
            'currentAssets',
            'fixedAssets',
            'currentLiabilities',
            'equity',
            'totalCurrentAssets',
            'totalFixedAssets',
            'totalCurrentLiabilities',
            'totalEquity',
            'totalAssets',
            'totalLiabilitiesEquity',
            'tanggal',
            'namaBulan',
            'namaPerusahaan',
            'labaRugi'
        ));
    }
    private function getCurrentAssets($idPerusahaan, $tanggal)
    {
        return DB::table('coa')
            ->leftJoin('jurnal_umum', function($join) use ($tanggal) {
                $join->on('coa.id_coa', '=', 'jurnal_umum.id_coa')
                     ->where('jurnal_umum.tanggal_jurnal', '<=', $tanggal);
            })
            ->select(
                'coa.id_coa',
                'coa.kode_akun',
                'coa.nama_akun',
                DB::raw('COALESCE(coa.saldo_awal, 0) + 
                    COALESCE(SUM(jurnal_umum.debit), 0) - 
                    COALESCE(SUM(jurnal_umum.credit), 0) as ending_balance')
            )
            ->where('coa.kelompok_akun', 1)
            ->where('coa.id_perusahaan', $idPerusahaan)
            ->where('coa.kode_akun', 'like', '11%')
            ->groupBy('coa.id_coa', 'coa.kode_akun', 'coa.nama_akun', 'coa.saldo_awal')
            ->orderBy('coa.kode_akun')
            ->get();
    }

    private function getFixedAssets($idPerusahaan, $tanggal)
    {
        $fixedAssets = DB::table('coa as c1')
            ->leftJoin('jurnal_umum as j1', function($join) use ($tanggal) {
                $join->on('c1.id_coa', '=', 'j1.id_coa')
                     ->where('j1.tanggal_jurnal', '<=', $tanggal);
            })
            ->leftJoin('coa as c2', function($join) {
                $join->on(DB::raw('CONCAT(LEFT(c1.kode_akun, 3), "99")'), '=', 'c2.kode_akun')
                     ->where('c2.id_perusahaan', '=', DB::raw('c1.id_perusahaan'));
            })
            ->leftJoin('jurnal_umum as j2', function($join) use ($tanggal) {
                $join->on('c2.id_coa', '=', 'j2.id_coa')
                     ->where('j2.tanggal_jurnal', '<=', $tanggal);
            })
            ->select(
                'c1.id_coa',
                'c1.kode_akun',
                'c1.nama_akun',
                DB::raw('COALESCE(c1.saldo_awal, 0) + 
                    COALESCE(SUM(j1.debit), 0) - 
                    COALESCE(SUM(j1.credit), 0) as asset_value'),
                DB::raw('COALESCE(c2.saldo_awal, 0) + 
                    COALESCE(SUM(j2.debit), 0) - 
                    COALESCE(SUM(j2.credit), 0) as accumulated_depreciation'),
                DB::raw('(COALESCE(c1.saldo_awal, 0) + 
                    COALESCE(SUM(j1.debit), 0) - 
                    COALESCE(SUM(j1.credit), 0)) -
                    (COALESCE(c2.saldo_awal, 0) + 
                    COALESCE(SUM(j2.debit), 0) - 
                    COALESCE(SUM(j2.credit), 0)) as net_value')
            )
            ->where('c1.kelompok_akun', 1)
            ->where('c1.id_perusahaan', $idPerusahaan)
            ->where('c1.kode_akun', 'like', '12%')
            ->whereRaw('RIGHT(c1.kode_akun, 2) != "99"')
            ->groupBy('c1.id_coa', 'c1.kode_akun', 'c1.nama_akun', 
                     'c1.saldo_awal', 'c2.saldo_awal')
            ->orderBy('c1.kode_akun')
            ->get();

        return $fixedAssets;
    }
    private function getCurrentLiabilities($idPerusahaan, $tanggal)
    {
        return DB::table('coa')
            ->leftJoin('jurnal_umum', function($join) use ($tanggal) {
                $join->on('coa.id_coa', '=', 'jurnal_umum.id_coa')
                     ->where('jurnal_umum.tanggal_jurnal', '<=', $tanggal);
            })
            ->select(
                'coa.id_coa',
                'coa.kode_akun',
                'coa.nama_akun',
                DB::raw('COALESCE(coa.saldo_awal, 0) - 
                    COALESCE(SUM(jurnal_umum.debit), 0) + 
                    COALESCE(SUM(jurnal_umum.credit), 0) as ending_balance')
            )
            ->where('coa.kelompok_akun', 2)
            ->where('coa.id_perusahaan', $idPerusahaan)
            ->where('coa.kode_akun', 'like', '21%')
            ->groupBy('coa.id_coa', 'coa.kode_akun', 'coa.nama_akun', 'coa.saldo_awal')
            ->orderBy('coa.kode_akun')
            ->get();
    }

    private function getEquity($idPerusahaan, $tanggal, $labaRugi)
    {
        $equity = DB::table('coa')
            ->leftJoin('jurnal_umum', function($join) use ($tanggal) {
                $join->on('coa.id_coa', '=', 'jurnal_umum.id_coa')
                     ->where('jurnal_umum.tanggal_jurnal', '<=', $tanggal);
            })
            ->select(
                'coa.id_coa',
                'coa.kode_akun',
                'coa.nama_akun',
                DB::raw('COALESCE(coa.saldo_awal, 0) - 
                    COALESCE(SUM(jurnal_umum.debit), 0) + 
                    COALESCE(SUM(jurnal_umum.credit), 0) as ending_balance')
            )
            ->where('coa.kelompok_akun', 3)
            ->where('coa.id_perusahaan', $idPerusahaan)
            ->where('coa.kode_akun', 'like', '31%')
            ->groupBy('coa.id_coa', 'coa.kode_akun', 'coa.nama_akun', 'coa.saldo_awal')
            ->orderBy('coa.kode_akun')
            ->get();

        // Add laba rugi to equity
        $equity->push((object)[
            'id_coa' => null,
            'kode_akun' => '-',
            'nama_akun' => 'Laba/Rugi',
            'ending_balance' => $labaRugi
        ]);

        return $equity;
    }
}