<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller; // Import the correct Controller class
use App\Models\Laporan\JurnalUmum;
use App\Models\Masterdata\Coa; // Assuming Coa is defined here
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class JurnalUmumController extends Controller
{
    // Display all journal entries with filtering and pagination
    public function index(Request $request)
    {
        $id_perusahaan = Auth::user()->id_perusahaan;
        $jurnal = JurnalUmum::where('id_perusahaan', $id_perusahaan)->get();
        // Get the search term and filter type from the request
        $filter = $request->input('filter');
        $search = $request->input('search');

        // Query for JurnalUmum entries with eager loading
        $query = JurnalUmum::with(['coa', 'perusahaan']); // Use eager loading

        // Filter by search term
        if ($search) {
            $query->where('nama_akun', 'like', '%' . $search . '%')
                ->orWhere('kode_akun', 'like', '%' . $search . '%');
        }

        // Filter by type (you may adjust the filtering logic according to your needs)
        if ($filter) {
            $query->where('nama_akun', 'like', '%' . $filter . '%');  // Changed to 'like' for flexibility
        }

        // Fetch the filtered results
        $jurnal = $query->paginate(10);

        // Get distinct nama_akun values for the filter dropdown
        $filters = JurnalUmum::select('nama_akun')->distinct()->get();

        $groupedJurnals = $jurnal->groupBy('transaction_id'); // assuming 'transaction_id' exists and is used for pairing

        // Pass the filtered, paginated, and grouped results to the view
        return view('laporan.jurnal_umum.index', compact('jurnal', 'filters', 'groupedJurnals'));
    }


    // Display Buku Besar
    public function bukuBesar(Request $request)
    {
        // Get all COA for dropdown
        $coas = Coa::all();

        // Get the selected account
        $selectedAccount = $request->input('account');
        $transactions = [];
        $saldoAwal = 0;
        $currentBalance = 0;

        if ($selectedAccount) {
            // Fetch the COA record for the selected account
            $coa = Coa::find($selectedAccount);

            if ($coa) {
                // Get the starting saldo_awal from the Coa table
                $saldoAwal = $coa->saldo_awal;

                // Fetch all journal entries for the selected account
                $transactions = JurnalUmum::where('kode_akun', $coa->kode_akun)
                    ->orderBy('tanggal_jurnal', 'asc')
                    ->get();

                // Initialize current balance with saldo_awal
                $currentBalance = $saldoAwal;

                // Fetch the account type (posisi_debit_credit) from TipeAkun
                $tipeAkun = $coa->tipeAkun;

                // Calculate the balance by iterating through the journal entries
                foreach ($transactions as $transaction) {
                    if ($tipeAkun && $tipeAkun->posisi_debit_credit === 'debit') {
                        // If posisi_debit_credit is 'debit', debit increases the balance
                        if ($transaction->debit) {
                            $currentBalance += $transaction->debit;
                        }
                        if ($transaction->credit) {
                            $currentBalance -= $transaction->credit;
                        }
                    } else {
                        // If posisi_debit_credit is 'credit', credit increases the balance
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

        // Fetch total balances of all accounts, sum debit and credit
        $totalBalances = Coa::withSum('jurnalUmums as total_debit', 'debit')
            ->withSum('jurnalUmums as total_credit', 'credit')
            ->get();

        // Fetch all transactions for View 3 and order by account name (nama_akun)
        $allTransactions = JurnalUmum::with('coa')
            ->join('coa', 'jurnal_umum.kode_akun', '=', 'coa.kode_akun')
            ->orderBy('coa.nama_akun', 'asc') // Order by account name
            ->get();

        // Sum up the grand totals for debit and credit
        $grandTotalDebit = $allTransactions->sum('debit');
        $grandTotalCredit = $allTransactions->sum('credit');

        // Return the view with all the required data
        return view('journal.buku_besar', compact(
            'coas',
            'selectedAccount',
            'transactions',
            'saldoAwal',
            'currentBalance',
            'totalBalances',
            'allTransactions',
            'grandTotalDebit',
            'grandTotalCredit'
        ));
    }
}
