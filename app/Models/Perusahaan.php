<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Perusahaan extends Model
{
    use HasFactory;

    protected $table = 'perusahaan';
    protected $fillable = ['nama', 'alamat', 'jenis_perusahaan', 'kode_perusahaan'];
    protected $primaryKey = 'id_perusahaan';

    // Event to handle what happens after a Perusahaan is created
    protected static function booted()
    {
        static::created(function ($perusahaan) {
            // Automatically create COA data for the new Perusahaan
            $perusahaan->createCoaForPerusahaan();
        });
    }

    /**
     * Create default COA entries linked to the newly created Perusahaan.
     */
    public function createCoaForPerusahaan()
    {
        DB::table('coa_kelompok')->insert([
            ['kelompok_akun' => '11', 'nama_kelompok_akun' => 'Aktiva', 'header_akun' => null],
            ['kelompok_akun' => '111', 'nama_kelompok_akun' => 'Aktiva Lancar', 'header_akun' => '11'],
            ['kelompok_akun' => '112', 'nama_kelompok_akun' => 'Aktiva Tetap', 'header_akun' => '11'],
            ['kelompok_akun' => '210', 'nama_kelompok_akun' => 'Kewajiban', 'header_akun' => null],
            ['kelompok_akun' => '310', 'nama_kelompok_akun' => 'Modal', 'header_akun' => null],
            ['kelompok_akun' => '410', 'nama_kelompok_akun' => 'Penjualan', 'header_akun' => null],
            ['kelompok_akun' => '510', 'nama_kelompok_akun' => 'Pembelian', 'header_akun' => null],
        ]);

        DB::table('coa')->insert([
            ['kode' => '01', 'nama_akun' => 'Kas', 'kelompok_akun' => 'Aktiva Lancar', 'posisi_d_c' => 'Debit', 'saldo_awal' => 1, 'id_perusahaan' => $this->id_perusahaan, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => '01', 'nama_akun' => 'Peralatan Salon', 'kelompok_akun' => 'Aktiva Tetap', 'posisi_d_c' => 'Debit', 'saldo_awal' => 1, 'id_perusahaan' => $this->id_perusahaan, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => '01', 'nama_akun' => 'Utang Usaha', 'kelompok_akun' => 'Kewajiban', 'posisi_d_c' => 'Kredit', 'saldo_awal' => 1, 'id_perusahaan' => $this->id_perusahaan, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => '01', 'nama_akun' => 'Modal Pemilik', 'kelompok_akun' => 'Modal', 'posisi_d_c' => 'Kredit', 'saldo_awal' => 1, 'id_perusahaan' => $this->id_perusahaan, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => '01', 'nama_akun' => 'Penjualan', 'kelompok_akun' => 'Penjualan', 'posisi_d_c' => 'Kredit', 'saldo_awal' => 1, 'id_perusahaan' => $this->id_perusahaan, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    // Define a one-to-many relationship with users
    public function users()
    {
        return $this->hasMany(User::class, 'id_perusahaan');
    }

    // Define the owner relationship (only fetch the user with the 'owner' role)
    public function owner()
    {
        return $this->hasOne(User::class, 'id_perusahaan')->where('role', 'owner');
    }
}
