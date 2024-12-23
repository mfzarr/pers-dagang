<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;
use App\Models\Masterdata\Karyawan;
use App\Models\Transaksi\Presensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PresensiController extends Controller
{
    public function index()
    {
        // Get today's date
        $today = now()->format('Y-m-d');

        // Get the attendance summary for the company
        $attendanceSummary = Presensi::whereHas('karyawan', function ($query) {
            $query->where('id_perusahaan', auth()->user()->perusahaan->id_perusahaan);
        })
            ->get()
            ->groupBy('tanggal_presensi')  // Group by date
            ->map(function ($dateRecords) {
                return [
                    'hadir' => $dateRecords->where('status', 'hadir')->count(),
                    'sakit' => $dateRecords->where('status', 'sakit')->count(),
                    'izin' => $dateRecords->where('status', 'izin')->count(),
                    'alpha' => $dateRecords->where('status', 'alpha')->count(),
                    'terlambat' => $dateRecords->where('status', 'terlambat')->count(),
                ];
            });

        return view('transaksi.presensi.index', compact('attendanceSummary', 'today'));
    }

    // Display attendance form for today for the logged-in user's company
    public function create()
    {
        // Get the logged-in user's company ID
        $perusahaanId = auth()->user()->perusahaan->id_perusahaan;

        // Get the list of karyawans for this company
        $karyawans = Karyawan::where('id_perusahaan', $perusahaanId)->get();

        // Get today's date
        $today = now()->format('Y-m-d');

        return view('transaksi.presensi.create', compact('karyawans', 'today'));
    }
    public function update(Request $request, $date)
    {
        // Validate the incoming request
        $request->validate([
            'status' => 'required|array',
            'status.*' => 'in:hadir,izin,sakit,alpha,terlambat',
        ]);

        // Loop through the status values and update each attendance record
        foreach ($request->status as $karyawanId => $status) {
            Presensi::where('id_karyawan', $karyawanId)
                ->where('tanggal_presensi', $date)
                ->where('id_perusahaan', auth()->user()->perusahaan->id_perusahaan)
                ->update(['status' => $status]);
        }

        // Redirect back to the index route after updating
        return redirect()->route('presensi.index')->with('success', 'Attendance updated successfully');
    }

    public function edit($date)
    {
        // Get the attendance records for the specified date
        $attendance = Presensi::where('tanggal_presensi', $date)
            ->where('id_perusahaan', auth()->user()->perusahaan->id_perusahaan)
            ->get();

        return view('transaksi.presensi.edit', compact('attendance', 'date'));
    }


    public function destroy($date)
    {
        // Delete the attendance records for the specified date
        Presensi::where('tanggal_presensi', $date)
            ->where('id_perusahaan', auth()->user()->perusahaan->id_perusahaan)
            ->delete();

        return redirect()->route('presensi.index')->with('success', 'Attendance records deleted successfully.');
    }


    // Store the attendance record for each employee
    public function store(Request $request)
    {
        $request->validate([
            'tanggal_presensi' => 'required|date',
            'status' => 'required|array',
            'status.*' => 'in:hadir,izin,sakit,alpha,terlambat',
        ]);

        // Loop through each employee and save/update their attendance status
        foreach ($request->status as $karyawanId => $status) {
            // Check if the attendance record for this employee on the specified date exists
            $attendance = Presensi::where('id_karyawan', $karyawanId)
                ->where('tanggal_presensi', $request->tanggal_presensi)
                ->first();

            if ($attendance) {
                // If the record exists, update it
                $attendance->update([
                    'status' => $status,
                ]);
            } else {
                // If the record does not exist, create a new one
                Presensi::create([
                    'id_karyawan' => $karyawanId,
                    'tanggal_presensi' => $request->tanggal_presensi,
                    'status' => $status,
                    'id_perusahaan' => auth()->user()->perusahaan->id_perusahaan,
                ]);
            }
        }

        return redirect()->route('presensi.index')->with('success', 'Attendance records updated successfully.');
    }


    // Show detailed attendance records for a specific date
    public function show($date)
    {
        $attendance = Presensi::where('tanggal_presensi', $date)
            ->where('id_perusahaan', auth()->user()->perusahaan->id_perusahaan)
            ->get();

        return view('transaksi.presensi.show', compact('attendance', 'date'));
    }
}
