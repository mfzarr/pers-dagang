<?php

// File: app/Http/Controllers/Masterdata/KaryawanController.php

namespace App\Http\Controllers\Masterdata;

use App\Http\Controllers\Controller;
use App\Models\Masterdata\Karyawan;
use App\Models\Masterdata\Jabatan;
use App\Models\User; // Import the User model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KaryawanController extends Controller
{



    public function index()
    {
        $id_perusahaan = Auth::user()->id_perusahaan;

        $karyawans = Karyawan::where('karyawan.id_perusahaan', $id_perusahaan) // Specify 'karyawan.id_perusahaan'
            ->join('jabatan', 'karyawan.id_jabatan', '=', 'jabatan.id_jabatan')
            ->select('karyawan.*', 'jabatan.tarif_tetap')
            ->get();

        return view('masterdata.karyawan.index', compact('karyawans'));
    }


    public function create()
    {
        $id_perusahaan = Auth::user()->id_perusahaan;
        $jabatans = Jabatan::where('id_perusahaan', $id_perusahaan)->get();
        $users = User::where('id_perusahaan', $id_perusahaan)->get(); // Fetch users of the same perusahaan

        return view('masterdata.karyawan.create', compact('jabatans', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|max:255',
            'no_telp' => 'required|max:255',
            'jenis_kelamin' => 'required|max:255',
            'email' => 'required|email|max:255',
            'alamat' => 'required|max:255',
            'status' => 'required',
            'id_jabatan' => 'required|exists:jabatan,id_jabatan',
            'id_user' => 'nullable|exists:users,id'
        ]);

        Karyawan::create([
            'nama' => $request->nama,
            'no_telp' => $request->no_telp,
            'jenis_kelamin' => $request->jenis_kelamin,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'status' => $request->status,
            'id_jabatan' => $request->id_jabatan,
            'id_perusahaan' => Auth::user()->id_perusahaan,
            'id_user' => $request->id_user
        ]);

        return redirect()->route('karyawan.index')->with('success', 'Karyawan created successfully.');
    }


    public function edit($id)
    {
        $id_perusahaan = Auth::user()->id_perusahaan;
        $karyawan = Karyawan::where('id_perusahaan', $id_perusahaan)->findOrFail($id);
        $jabatans = Jabatan::where('id_perusahaan', $id_perusahaan)->get();
        $users = User::where('id_perusahaan', $id_perusahaan)->get();

        return view('masterdata.karyawan.edit', compact('karyawan', 'jabatans', 'users'));
    }
}
