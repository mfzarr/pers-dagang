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
            ['kelompok_akun' => '1', 'nama_kelompok_akun' => 'Aset', 'id_perusahaan' => $this->id_perusahaan, 'created_at' => now(), 'updated_at' => now()],
            ['kelompok_akun' => '2', 'nama_kelompok_akun' => 'Kewajiban', 'id_perusahaan' => $this->id_perusahaan, 'created_at' => now(), 'updated_at' => now()],
            ['kelompok_akun' => '3', 'nama_kelompok_akun' => 'Ekuitas', 'id_perusahaan' => $this->id_perusahaan, 'created_at' => now(), 'updated_at' => now()],
            ['kelompok_akun' => '4', 'nama_kelompok_akun' => 'Penjualan', 'id_perusahaan' => $this->id_perusahaan, 'created_at' => now(), 'updated_at' => now()],
            ['kelompok_akun' => '5', 'nama_kelompok_akun' => 'Pembelian dan Beban', 'id_perusahaan' => $this->id_perusahaan, 'created_at' => now(), 'updated_at' => now()],
        // DB::table('coa_kelompok')->insert([
        //     ['kelompok_akun' => '11', 'nama_kelompok_akun' => 'Aktiva', 'header_akun' => null, 'id_perusahaan' => $this->id_perusahaan, 'created_at' => now(), 'updated_at' => now()],
        //     ['kelompok_akun' => '111', 'nama_kelompok_akun' => 'Aktiva Lancar', 'header_akun' => '11', 'id_perusahaan' => $this->id_perusahaan, 'created_at' => now(), 'updated_at' => now()],
        //     ['kelompok_akun' => '121', 'nama_kelompok_akun' => 'Aktiva Tetap', 'header_akun' => '11', 'id_perusahaan' => $this->id_perusahaan, 'created_at' => now(), 'updated_at' => now()],
        //     ['kelompok_akun' => '21', 'nama_kelompok_akun' => 'Kewajiban', 'header_akun' => null, 'id_perusahaan' => $this->id_perusahaan, 'created_at' => now(), 'updated_at' => now()],
        //     ['kelompok_akun' => '211', 'nama_kelompok_akun' => 'Kewajiban Jangka Pendek', 'header_akun' => '21', 'id_perusahaan' => $this->id_perusahaan, 'created_at' => now(), 'updated_at' => now()],
        //     ['kelompok_akun' => '221', 'nama_kelompok_akun' => 'Kewajiban Jangka Panjang', 'header_akun' => '21', 'id_perusahaan' => $this->id_perusahaan, 'created_at' => now(), 'updated_at' => now()],
        //     ['kelompok_akun' => '31', 'nama_kelompok_akun' => 'Ekuitas', 'header_akun' => null, 'id_perusahaan' => $this->id_perusahaan, 'created_at' => now(), 'updated_at' => now()],
        //     ['kelompok_akun' => '311', 'nama_kelompok_akun' => 'Modal', 'header_akun' => '31', 'id_perusahaan' => $this->id_perusahaan, 'created_at' => now(), 'updated_at' => now()],
        //     ['kelompok_akun' => '41', 'nama_kelompok_akun' => 'Pendapatan dan Penjualan', 'header_akun' => null, 'id_perusahaan' => $this->id_perusahaan, 'created_at' => now(), 'updated_at' => now()],
        //     ['kelompok_akun' => '411', 'nama_kelompok_akun' => 'Pendapatan', 'header_akun' => '41', 'id_perusahaan' => $this->id_perusahaan, 'created_at' => now(), 'updated_at' => now()],
        //     ['kelompok_akun' => '412', 'nama_kelompok_akun' => 'Penjualan', 'header_akun' => '41', 'id_perusahaan' => $this->id_perusahaan, 'created_at' => now(), 'updated_at' => now()],
        //     ['kelompok_akun' => '51', 'nama_kelompok_akun' => 'Pembelian dan Beban', 'header_akun' => null, 'id_perusahaan' => $this->id_perusahaan, 'created_at' => now(), 'updated_at' => now()],
        //     ['kelompok_akun' => '511', 'nama_kelompok_akun' => 'Pembelian', 'header_akun' => '51', 'id_perusahaan' => $this->id_perusahaan, 'created_at' => now(), 'updated_at' => now()],
        //     ['kelompok_akun' => '512', 'nama_kelompok_akun' => 'Beban', 'header_akun' => '51', 'id_perusahaan' => $this->id_perusahaan, 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('coa')->insert([
            ['kode_akun' => '1101', 'nama_akun' => 'Kas', 'kelompok_akun' => '1', 'posisi_d_c' => 'Debit', 'saldo_awal' => 0, 'status' => 'seeder', 'id_perusahaan' => $this->id_perusahaan, 'created_at' => now(), 'updated_at' => now()],
            ['kode_akun' => '1102', 'nama_akun' => 'Piutang Dagang', 'kelompok_akun' => '1', 'posisi_d_c' => 'Debit', 'saldo_awal' => 0, 'status' => 'seeder', 'id_perusahaan' => $this->id_perusahaan, 'created_at' => now(), 'updated_at' => now()],
            ['kode_akun' => '1103', 'nama_akun' => 'Persediaan Barang Dagang', 'kelompok_akun' => '1', 'posisi_d_c' => 'Debit', 'saldo_awal' => 0, 'status' => 'seeder', 'id_perusahaan' => $this->id_perusahaan, 'created_at' => now(), 'updated_at' => now()],
            ['kode_akun' => '1104', 'nama_akun' => 'Perlengkapan', 'kelompok_akun' => '1', 'posisi_d_c' => 'Debit', 'saldo_awal' => 0, 'status' => 'seeder', 'id_perusahaan' => $this->id_perusahaan, 'created_at' => now(), 'updated_at' => now()],
            ['kode_akun' => '1201', 'nama_akun' => 'Peralatan', 'kelompok_akun' => '1', 'posisi_d_c' => 'Debit', 'saldo_awal' => 0, 'status' => 'seeder', 'id_perusahaan' => $this->id_perusahaan, 'created_at' => now(), 'updated_at' => now()],
            ['kode_akun' => '2101', 'nama_akun' => 'Utang Dagang', 'kelompok_akun' => '2', 'posisi_d_c' => 'Kredit', 'saldo_awal' => 0, 'status' => 'seeder', 'id_perusahaan' => $this->id_perusahaan, 'created_at' => now(), 'updated_at' => now()],
            ['kode_akun' => '3101', 'nama_akun' => 'Modal', 'kelompok_akun' => '3', 'posisi_d_c' => 'Kredit', 'saldo_awal' => 0, 'status' => 'manual', 'id_perusahaan' => $this->id_perusahaan, 'created_at' => now(), 'updated_at' => now()],
            ['kode_akun' => '4101', 'nama_akun' => 'Penjualan', 'kelompok_akun' => '4', 'posisi_d_c' => 'Kredit', 'saldo_awal' => 0, 'status' => 'seeder', 'id_perusahaan' => $this->id_perusahaan, 'created_at' => now(), 'updated_at' => now()],
            ['kode_akun' => '5101', 'nama_akun' => 'Harga Pokok Penjualan', 'kelompok_akun' => '5', 'posisi_d_c' => 'Debit', 'saldo_awal' => 0, 'status' => 'seeder', 'id_perusahaan' => $this->id_perusahaan, 'created_at' => now(), 'updated_at' => now()],
            ['kode_akun' => '5203', 'nama_akun' => 'Beban Gaji', 'kelompok_akun' => '5', 'posisi_d_c' => 'Debit', 'saldo_awal' => 0, 'status' => 'manual', 'id_perusahaan' => $this->id_perusahaan, 'created_at' => now(), 'updated_at' => now()],
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
