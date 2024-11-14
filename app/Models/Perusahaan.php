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
            ['kelompok_akun' => '11', 'nama_kelompok_akun' => 'Aktiva', 'header_akun' => null, 'id_perusahaan' => $this->id_perusahaan, 'created_at' => now(), 'updated_at' => now()],
            ['kelompok_akun' => '111', 'nama_kelompok_akun' => 'Aktiva Lancar', 'header_akun' => '11', 'id_perusahaan' => $this->id_perusahaan, 'created_at' => now(), 'updated_at' => now()],
            ['kelompok_akun' => '121', 'nama_kelompok_akun' => 'Aktiva Tetap', 'header_akun' => '11', 'id_perusahaan' => $this->id_perusahaan, 'created_at' => now(), 'updated_at' => now()],
            ['kelompok_akun' => '21', 'nama_kelompok_akun' => 'Kewajiban', 'header_akun' => null, 'id_perusahaan' => $this->id_perusahaan, 'created_at' => now(), 'updated_at' => now()],
            ['kelompok_akun' => '211', 'nama_kelompok_akun' => 'Kewajiban Jangka Pendek', 'header_akun' => '21', 'id_perusahaan' => $this->id_perusahaan, 'created_at' => now(), 'updated_at' => now()],
            ['kelompok_akun' => '221', 'nama_kelompok_akun' => 'Kewajiban Jangka Panjang', 'header_akun' => '21', 'id_perusahaan' => $this->id_perusahaan, 'created_at' => now(), 'updated_at' => now()],
            ['kelompok_akun' => '31', 'nama_kelompok_akun' => 'Ekuitas', 'header_akun' => null, 'id_perusahaan' => $this->id_perusahaan, 'created_at' => now(), 'updated_at' => now()],
            ['kelompok_akun' => '311', 'nama_kelompok_akun' => 'Modal', 'header_akun' => '31', 'id_perusahaan' => $this->id_perusahaan, 'created_at' => now(), 'updated_at' => now()],
            ['kelompok_akun' => '41', 'nama_kelompok_akun' => 'Pendapatan dan Penjualan', 'header_akun' => null, 'id_perusahaan' => $this->id_perusahaan, 'created_at' => now(), 'updated_at' => now()],
            ['kelompok_akun' => '411', 'nama_kelompok_akun' => 'Pendapatan', 'header_akun' => '41', 'id_perusahaan' => $this->id_perusahaan, 'created_at' => now(), 'updated_at' => now()],
            ['kelompok_akun' => '412', 'nama_kelompok_akun' => 'Penjualan', 'header_akun' => '41', 'id_perusahaan' => $this->id_perusahaan, 'created_at' => now(), 'updated_at' => now()],
            ['kelompok_akun' => '51', 'nama_kelompok_akun' => 'Pembelian dan Beban', 'header_akun' => null, 'id_perusahaan' => $this->id_perusahaan, 'created_at' => now(), 'updated_at' => now()],
            ['kelompok_akun' => '511', 'nama_kelompok_akun' => 'Pembelian', 'header_akun' => '51', 'id_perusahaan' => $this->id_perusahaan, 'created_at' => now(), 'updated_at' => now()],
            ['kelompok_akun' => '512', 'nama_kelompok_akun' => 'Beban', 'header_akun' => '51', 'id_perusahaan' => $this->id_perusahaan, 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('coa')->insert([
            ['kode' => '1110', 'nama_akun' => 'Kas', 'kelompok_akun' => '111', 'posisi_d_c' => 'Debit', 'saldo_awal' => 0, 'id_perusahaan' => $this->id_perusahaan, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => '1111', 'nama_akun' => 'Perlengkapan', 'kelompok_akun' => '111', 'posisi_d_c' => 'Debit', 'saldo_awal' => 0, 'id_perusahaan' => $this->id_perusahaan, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => '1210', 'nama_akun' => 'Tanah', 'kelompok_akun' => '121', 'posisi_d_c' => 'Debit', 'saldo_awal' => 0, 'id_perusahaan' => $this->id_perusahaan, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => '1211', 'nama_akun' => 'Bangunan', 'kelompok_akun' => '121', 'posisi_d_c' => 'Debit', 'saldo_awal' => 0, 'id_perusahaan' => $this->id_perusahaan, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => '1120', 'nama_akun' => 'Peralatan', 'kelompok_akun' => '121', 'posisi_d_c' => 'Debit', 'saldo_awal' => 0, 'id_perusahaan' => $this->id_perusahaan, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => '2110', 'nama_akun' => 'Utang Usaha', 'kelompok_akun' => '211', 'posisi_d_c' => 'Kredit', 'saldo_awal' => 0, 'id_perusahaan' => $this->id_perusahaan, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => '3110', 'nama_akun' => 'Modal Pemilik', 'kelompok_akun' => '311', 'posisi_d_c' => 'Kredit', 'saldo_awal' => 0, 'id_perusahaan' => $this->id_perusahaan, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => '4120', 'nama_akun' => 'Penjualan', 'kelompok_akun' => '412', 'posisi_d_c' => 'Kredit', 'saldo_awal' => 0, 'id_perusahaan' => $this->id_perusahaan, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => '5110', 'nama_akun' => 'Pembelian', 'kelompok_akun' => '511', 'posisi_d_c' => 'Debit', 'saldo_awal' => 0, 'id_perusahaan' => $this->id_perusahaan, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => '5120', 'nama_akun' => 'Beban-Beban', 'kelompok_akun' => '512', 'posisi_d_c' => 'Debit', 'saldo_awal' => 0, 'id_perusahaan' => $this->id_perusahaan, 'created_at' => now(), 'updated_at' => now()],
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
