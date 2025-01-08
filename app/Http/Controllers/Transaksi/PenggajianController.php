<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;
use App\Models\Transaksi\Penggajian;
use App\Models\masterdata\Karyawan;
use App\Models\Masterdata\Coa;
use App\Models\Laporan\JurnalUmum;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenggajianController extends Controller
{

    public function index(Request $request)
    {
        $id_perusahaan = Auth::user()->id_perusahaan;
        $penggajian = Penggajian::where('id_perusahaan', $id_perusahaan)
            ->with('karyawan') // Eager load 'karyawan'
            ->paginate(10);

        return view('transaksi.penggajian.index', compact('penggajian'));
    }


    public function create()
    {
        $id_perusahaan = Auth::user()->id_perusahaan;
        $karyawan = Karyawan::where('id_perusahaan', $id_perusahaan)->get();

        return view('transaksi.penggajian.create', compact('karyawan'));
    }

    public function getTotalKehadiranByKaryawan($id)
    {
        // Count the total 'hadir' status from presensi table for the selected employee
        $total_kehadiran = \DB::table('presensi')
            ->where('id_karyawan', $id)
            ->where('status', 'hadir')
            ->count();

        return response()->json(['total_kehadiran' => $total_kehadiran]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_karyawan' => 'required|exists:karyawan,id_karyawan',
            'tanggal_penggajian' => 'required|date',
            'bonus' => 'required|numeric|min:0|max:100',
            'total_service' => 'required|integer',
            'bonus_kehadiran' => 'required|integer',
            'tunjangan_makan' => 'required|integer',
            'tunjangan_jabatan' => 'required|integer',
            'lembur' => 'required|integer',
            'potongan_gaji' => 'required|integer',
        ]);

        $karyawan = Karyawan::find($request->id_karyawan);
        $jabatan = $karyawan->jabatan;

        // Fetch total_kehadiran from the presensi table
        $total_kehadiran = \DB::table('presensi')
            ->where('id_karyawan', $request->id_karyawan)
            ->where('status', 'hadir')
            ->count();

        $bonus_service = ($request->bonus / 100) * $request->total_service;
        $total_bonus_kehadiran = $total_kehadiran * $request->bonus_kehadiran;
        $total_gaji_bersih = $jabatan->tarif + $bonus_service + $total_bonus_kehadiran - $jabatan->asuransi + $request->tunjangan_makan + $request->tunjangan_jabatan + $request->lembur - $request->potongan_gaji;

        $no_transaksi_gaji = 'GJ/' . now()->format('Ymd') . '/' . str_pad(Penggajian::max('id_gaji') + 1, 4, '0', STR_PAD_LEFT);

        // Create Penggajian (payroll record)
        $penggajian = Penggajian::create([
            'no_transaksi_gaji' => $no_transaksi_gaji,
            'tanggal_penggajian' => $request->tanggal_penggajian,
            'id_karyawan' => $request->id_karyawan,
            'tarif' => $jabatan->tarif,
            'bonus' => $request->bonus,
            'total_service' => $request->total_service,
            'bonus_service' => $bonus_service,
            'total_kehadiran' => $total_kehadiran,
            'bonus_kehadiran' => $request->bonus_kehadiran,
            'total_bonus_kehadiran' => $total_bonus_kehadiran,
            'tunjangan_makan' => $request->tunjangan_makan,
            'tunjangan_jabatan' => $request->tunjangan_jabatan,
            'lembur' => $request->lembur,
            'potongan_gaji' => $request->potongan_gaji,
            'total_gaji_bersih' => $total_gaji_bersih,
            'id_perusahaan' => Auth::user()->id_perusahaan
        ]);

        // Create journal entries after successfully creating the payroll record
        $this->createJournalForPenggajian($penggajian);

        return redirect()->route('penggajian.index')->with('success', 'Penggajian created successfully.');
    }

    /**
     * Create the journal entries for the Penggajian transaction.
     */
    protected function createJournalForPenggajian(Penggajian $penggajian)
    {
        $perusahaanId = $penggajian->id_perusahaan;

        // Get the COA (Chart of Accounts) for relevant accounts
        $akungaji = Coa::where('kode_akun', '5203')->first(); // Example: Salary Expense account
        $akunkas = Coa::where('kode_akun', '1101')->first(); // Example: Cash account

        $transactionId = Str::uuid();

        // Prepare the transaction entries
        $transactionData = [
            'tanggal_jurnal' => $penggajian->tanggal_penggajian,
            'transaction_id' => $transactionId,
            'entries' => [
                [
                    'id_coa' => $akungaji->id_coa,
                    'nama_akun' => $akungaji->nama_akun,
                    'kode_akun' => $akungaji->kode_akun,
                    'debit' => $penggajian->total_gaji_bersih, // Debit the salary expense
                    'credit' => null, // No credit here
                    'transaction_id' => $transactionId, // Reference the same transaction ID
                ],
                [
                    'id_coa' => $akunkas->id_coa,
                    'nama_akun' => $akunkas->nama_akun,
                    'kode_akun' => $akunkas->kode_akun,
                    'debit' => null, // No debit here
                    'credit' => $penggajian->total_gaji_bersih, // Credit the cash account
                    'transaction_id' => $transactionId, // Reference the same transaction ID
                ]
            ]
        ];

        // Create journal entries for this payroll transaction
        JurnalUmum::createFromTransaction($transactionData, $perusahaanId);
    }

    public function getTarifByKaryawan($id)
    {
        $karyawan = Karyawan::with('jabatan')->find($id);
        if ($karyawan && $karyawan->jabatan) {
            return response()->json(['tarif' => $karyawan->jabatan->tarif]);
        }
        return response()->json(['tarif' => 0]);
    }

    public function getTotalServiceByKaryawan($id)
    {
        // Sum all 'total' from 'penjualan' based on 'id_pegawai' in 'penjualan_detail'
        $total_service = \DB::table('penjualan_detail')
            ->join('penjualan', 'penjualan.id_penjualan', '=', 'penjualan_detail.id_penjualan')
            ->where('penjualan_detail.id_pegawai', $id)
            ->sum('penjualan.total');

        return response()->json(['total_service' => $total_service]);
    }

    public function show($id)
    {
        // Fetch Penggajian with the related Karyawan and Jabatan
        $penggajian = Penggajian::with(['karyawan.jabatan'])->findOrFail($id);

        return view('transaksi.penggajian.show', compact('penggajian'));
    }

    public function destroy($id)
    {
        $penggajian = Penggajian::findOrFail($id);
        $penggajian->delete();

        return redirect()->route('penggajian.index')->with('success', 'Penggajian deleted successfully.');
    }
}
