<?php

namespace App\Http\Controllers\laporan;

use App\Models\Laporan\JurnalUmum;
use App\Models\Masterdata\Coa; // Assuming Coa is defined here
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Masterdata\Perusahaan;
use Carbon\Carbon;

class JurnalUmumController extends Controller
{
    // Display all journal entries with filtering and pagination
    // public function index(Request $request)
    // {
    //     // Get the search term and filter type from the request
    //     $search = $request->input('search');
    //     $filter = $request->input('filter');
    //     $id_perusahaan = Auth::user()->id_perusahaan;
        
    //     // Query for JurnalUmum entries with eager loading
    //     $query = JurnalUmum::with(['coa', 'perusahaan'])
    //         ->where('id_perusahaan', $id_perusahaan); // Filter by id_perusahaan

    //     // Filter by search term
    //     if ($search) {
    //         $query->where(function($q) use ($search) {
    //             $q->where('nama_akun', 'like', '%' . $search . '%')
    //               ->orWhere('kode_akun', 'like', '%' . $search . '%');
    //         });
    //     }

    //     // Filter by type (you may adjust the filtering logic according to your needs)
    //     if ($filter) {
    //         $query->where('nama_akun', 'like', '%' . $filter . '%');  // Changed to 'like' for flexibility
    //     }

    //     // Paginate results (adjust the number of items per page as needed)
    //     $jurnals = $query->paginate(100);

    //     // Get distinct nama_akun values for the filter dropdown
    //     $filters = JurnalUmum::select('nama_akun')->distinct()->get();

    //     // Group the results by 'transaction_id' (or whatever field pairs the debit and credit transactions)
    //     $groupedJurnals = $jurnals->groupBy('transaction_id'); // assuming 'transaction_id' exists and is used for pairing

    //     // Pass the filtered, paginated, and grouped results to the view
    //     return view('laporan.jurnal_umum.index', compact('jurnals', 'filters', 'groupedJurnals'));
    // }

    // // Display Buku Besar
    // public function bukuBesar(Request $request)
    // {
    //     // Get the authenticated user's company ID
    //     $id_perusahaan = Auth::user()->id_perusahaan;

    //     // Get all COA for dropdown, filtered by the authenticated user's company
    //     $coas = Coa::where('id_perusahaan', $id_perusahaan)->get();

    //     // Get the selected account
    //     $selectedAccount = $request->input('account');
    //     $transactions = [];
    //     $saldoAwal = 0;
    //     $currentBalance = 0;

    //     if ($selectedAccount) {
    //         // Fetch the COA record for the selected account, filtered by the authenticated user's company
    //         $coa = Coa::where('id_perusahaan', $id_perusahaan)->find($selectedAccount);

    //         if ($coa) {
    //             // Get the starting saldo_awal from the Coa table
    //             $saldoAwal = $coa->saldo_awal;

    //             // Fetch all journal entries for the selected account
    //             $transactions = JurnalUmum::where('kode_akun', $coa->kode_akun)
    //                 ->where('id_perusahaan', $id_perusahaan)
    //                 ->orderBy('tanggal_jurnal', 'asc')
    //                 ->get();

    //             // Initialize current balance with saldo_awal
    //             $currentBalance = $saldoAwal;

    //             // Fetch the account type (posisi_debit_credit) from kelompokakun
    //             $kelompokakun = $coa->kelompokakun;

    //             // Calculate the balance by iterating through the journal entries
    //             foreach ($transactions as $transaction) {
    //                 if ($kelompokakun && $kelompokakun->posisi_debit_credit === 'debit') {
    //                     // If posisi_debit_credit is 'debit', debit increases the balance
    //                     if ($transaction->debit) {
    //                         $currentBalance += $transaction->debit;
    //                     }
    //                     if ($transaction->credit) {
    //                         $currentBalance -= $transaction->credit;
    //                     }
    //                 } else {
    //                     // If posisi_debit_credit is 'credit', credit increases the balance
    //                     if ($transaction->credit) {
    //                         $currentBalance += $transaction->credit;
    //                     }
    //                     if ($transaction->debit) {
    //                         $currentBalance -= $transaction->debit;
    //                     }
    //                 }
    //             }
    //         }
    //     }

    //     // Fetch total balances of all accounts, sum debit and credit, filtered by the authenticated user's company
    //     $totalBalances = Coa::where('id_perusahaan', $id_perusahaan)
    //         ->withSum('jurnalUmums as total_debit', 'debit')
    //         ->withSum('jurnalUmums as total_credit', 'credit')
    //         ->get();

    //     // Fetch all transactions for View 3 and order by account name (nama_akun), filtered by the authenticated user's company
    //     $allTransactions = JurnalUmum::with('coa')
    //         ->join('coa', 'jurnal_umum.kode_akun', '=', 'coa.kode_akun')
    //         ->where('coa.id_perusahaan', $id_perusahaan)
    //         ->orderBy('coa.nama_akun', 'asc') // Order by account name
    //         ->get();

    //     // Sum up the grand totals for debit and credit
    //     $grandTotalDebit = $allTransactions->sum('debit');
    //     $grandTotalCredit = $allTransactions->sum('credit');

    //     // Return the view with all the required data
    //     return view('laporan.buku_besar.index', compact(
    //         'coas',
    //         'selectedAccount',
    //         'transactions',
    //         'saldoAwal',
    //         'currentBalance',
    //         'totalBalances',
    //         'allTransactions',
    //         'grandTotalDebit',
    //         'grandTotalCredit'
    //     ));
    // }

    // Display all journal entries with filtering and pagination
    // JurnalUmumController.php
    public function index(Request $request)
    {
        $id_perusahaan = auth()->user()->id_perusahaan;
        $namabulan = Carbon::now()->format('F'); // Get the current month in full name

        // Get the current year and month for filtering
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;

        // Get the selected month from the request, default to the current month
        $selectedMonth = $request->input('month', $currentMonth); // Default to current month
        $selectedYear = $request->input('year', $currentYear);  // Default to current year

        // Query for JurnalUmum entries with eager loading, filtering by the selected month and year
        $query = JurnalUmum::with(['coa', 'perusahaan'])
            ->where('id_perusahaan', $id_perusahaan) // Filter by perusahaan
            ->whereYear('tanggal_jurnal', $selectedYear) // Filter by selected year
            ->whereMonth('tanggal_jurnal', $selectedMonth); // Filter by selected month

        // Get the search term and filter type from the request (this can be removed if no longer needed)
        $filter = $request->input('filter');

        // Rest of your filtering logic (this can also be removed if you don't want to use additional filters)
        if ($filter) {
            $query->where('nama_akun', 'like', '%' . $filter . '%');
        }

        $jurnals = $query->paginate(10);

        // Get filters only for this perusahaan (you can adjust this to show more useful filters)
        $filters = JurnalUmum::where('id_perusahaan', $id_perusahaan)
            ->select('nama_akun')
            ->distinct()
            ->get();

        $groupedJurnals = $jurnals->groupBy('transaction_id');

        // Fetch perusahaan (company) details
        $perusahaan = Perusahaan::where('id_perusahaan', $id_perusahaan)->first();

        // Get list of months for the dropdown
        $months = collect([
            1 => 'January',
            2 => 'February',
            3 => 'March',
            4 => 'April',
            5 => 'May',
            6 => 'June',
            7 => 'July',
            8 => 'August',
            9 => 'September',
            10 => 'October',
            11 => 'November',
            12 => 'December'
        ]);

        return view('laporan.jurnal_umum.index', compact('jurnals', 'filters', 'groupedJurnals', 'perusahaan', 'namabulan', 'months', 'selectedMonth', 'selectedYear'));
    }




    // Display Buku Besar
    public function bukuBesar(Request $request)
    {
        $id_perusahaan = auth()->user()->id_perusahaan;
    
        // Get COAs only for this perusahaan
        $coas = Coa::where('id_perusahaan', $id_perusahaan)->get();
    
        // Get selected month and year from the request, default to current month and year
        $selectedMonth = $request->input('month', Carbon::now()->month);
        $selectedYear = $request->input('year', Carbon::now()->year);
    
        $months = [
            1 => 'January',
            2 => 'February',
            3 => 'March',
            4 => 'April',
            5 => 'May',
            6 => 'June',
            7 => 'July',
            8 => 'August',
            9 => 'September',
            10 => 'October',
            11 => 'November',
            12 => 'December',
        ];
    
        // Filter transactions by selected month and year
        $transactions = [];
        $saldoAwal = 0;
        $currentBalance = 0;
    
        $selectedAccount = $request->input('account');
    
        if ($selectedAccount) {
            // Get the selected Coa for this perusahaan and account
            $coa = Coa::where('id_perusahaan', $id_perusahaan)
                ->where('id_coa', $selectedAccount)
                ->first();
    
            if ($coa) {
                $saldoAwal = $coa->saldo_awal;
    
                // Fetch journal entries for selected account and company, filtered by month and year
                $transactions = JurnalUmum::where('id_perusahaan', $id_perusahaan)
                    ->where('id_coa', $selectedAccount)
                    ->whereYear('tanggal_jurnal', $selectedYear)
                    ->whereMonth('tanggal_jurnal', $selectedMonth)
                    ->orderBy('tanggal_jurnal', 'asc')
                    ->get();
    
                $currentBalance = $saldoAwal;
                $kelompokakun = $coa->kelompokakun;
    
                $isAccumulatedDepreciation = stripos($coa->nama_akun, 'akumulasi penyusutan') !== false;
    
                foreach ($transactions as $transaction) {
                    if ($isAccumulatedDepreciation) {
                        // For accumulated depreciation accounts, credit increases the balance
                        if ($transaction->credit) {
                            $currentBalance += $transaction->credit;
                        }
                        if ($transaction->debit) {
                            $currentBalance -= $transaction->debit;
                        }
                    } else {
                        // For other accounts, use the original logic
                        if ($kelompokakun && $kelompokakun->posisi_debit_credit === 'debit') {
                            if ($transaction->debit) {
                                $currentBalance += $transaction->debit;
                            }
                            if ($transaction->credit) {
                                $currentBalance -= $transaction->credit;
                            }
                        } else {
                            if ($transaction->credit) {
                                $currentBalance += $transaction->credit;
                            }
                            if ($transaction->debit) {
                                $currentBalance -= $transaction->debit;
                            }
                        }
                    }
                }
            }
        }
    
        // Fetch total balances - fixed query, now including month and year filtering
        $totalBalances = Coa::where('id_perusahaan', $id_perusahaan)
            ->select('coa.*')
            ->selectRaw('(SELECT COALESCE(SUM(debit), 0) FROM jurnal_umum WHERE jurnal_umum.id_coa = coa.id_coa AND YEAR(tanggal_jurnal) = ? AND MONTH(tanggal_jurnal) = ?) as total_debit', [$selectedYear, $selectedMonth])
            ->selectRaw('(SELECT COALESCE(SUM(credit), 0) FROM jurnal_umum WHERE jurnal_umum.id_coa = coa.id_coa AND YEAR(tanggal_jurnal) = ? AND MONTH(tanggal_jurnal) = ?) as total_credit', [$selectedYear, $selectedMonth])
            ->get();
    
        // Fetch all transactions based on id_coa for the assigned perusahaan and month/year filter
        $allTransactions = JurnalUmum::with('coa')
            ->join('coa', function ($join) use ($id_perusahaan) {
                $join->on('jurnal_umum.id_coa', '=', 'coa.id_coa')
                    ->where('coa.id_perusahaan', '=', $id_perusahaan);
            })
            ->where('jurnal_umum.id_perusahaan', $id_perusahaan)
            ->whereYear('jurnal_umum.tanggal_jurnal', $selectedYear)
            ->whereMonth('jurnal_umum.tanggal_jurnal', $selectedMonth)
            ->orderBy('coa.nama_akun', 'asc')
            ->select('jurnal_umum.*', 'coa.nama_akun as coa_nama_akun')
            ->get();
    
        // Calculate grand totals
        $grandTotalDebit = $allTransactions->sum('debit');
        $grandTotalCredit = $allTransactions->sum('credit');
    
        return view('laporan.buku_besar.index', compact(
            'coas',
            'selectedAccount',
            'transactions',
            'saldoAwal',
            'currentBalance',
            'totalBalances',
            'allTransactions',
            'grandTotalDebit',
            'grandTotalCredit',
            'selectedMonth',
            'selectedYear',
            'months'
        ));
    }
    
    public function neracasaldo(Request $request)
    {
        $id_perusahaan = auth()->user()->id_perusahaan;
    
        // Get selected month and year from the request, default to current month and year
        $selectedMonth = $request->input('month', Carbon::now()->month);
        $selectedYear = $request->input('year', Carbon::now()->year);
    
        $months = [
            1 => 'January',
            2 => 'February',
            3 => 'March',
            4 => 'April',
            5 => 'May',
            6 => 'June',
            7 => 'July',
            8 => 'August',
            9 => 'September',
            10 => 'October',
            11 => 'November',
            12 => 'December',
        ];
    
        // Fetch total balances including saldo awal
        $totalBalances = Coa::where('id_perusahaan', $id_perusahaan)
            ->select('coa.*')
            ->selectRaw('
                CASE 
                    WHEN LOWER(nama_akun) LIKE "%akumulasi penyusutan%" THEN 0
                    ELSE (CASE WHEN kelompok_akun IN (1, 5) THEN saldo_awal ELSE 0 END) + 
                        (SELECT COALESCE(SUM(debit), 0) FROM jurnal_umum 
                        WHERE jurnal_umum.id_coa = coa.id_coa 
                        AND YEAR(tanggal_jurnal) = ? AND MONTH(tanggal_jurnal) = ?)
                END as total_debit', [$selectedYear, $selectedMonth])
            ->selectRaw('
                CASE 
                    WHEN LOWER(nama_akun) LIKE "%akumulasi penyusutan%" THEN saldo_awal + 
                        (SELECT COALESCE(SUM(credit), 0) FROM jurnal_umum 
                        WHERE jurnal_umum.id_coa = coa.id_coa 
                        AND YEAR(tanggal_jurnal) = ? AND MONTH(tanggal_jurnal) = ?)
                    ELSE (CASE WHEN kelompok_akun IN (2, 3, 4) THEN saldo_awal ELSE 0 END) + 
                        (SELECT COALESCE(SUM(credit), 0) FROM jurnal_umum 
                        WHERE jurnal_umum.id_coa = coa.id_coa 
                        AND YEAR(tanggal_jurnal) = ? AND MONTH(tanggal_jurnal) = ?)
                END as total_credit', [$selectedYear, $selectedMonth, $selectedYear, $selectedMonth])
            ->get();
    
        // Calculate grand totals
        $grandTotalDebit = $totalBalances->sum('total_debit');
        $grandTotalCredit = $totalBalances->sum('total_credit');
    
        return view('laporan.neraca_saldo.index', compact(
            'totalBalances',
            'grandTotalDebit',
            'grandTotalCredit',
            'selectedMonth',
            'selectedYear',
            'months'
        ));
    }
}
