<?php

namespace App\Models\Transaksi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Masterdata\Karyawan;

class Penggajian extends Model
{
    use HasFactory;

    protected $table = 'penggajian';
    protected $primaryKey = 'id_gaji';
    protected $guarded = [];

    // Update foreign key to match the database field `id_pegawai`
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan', 'id_karyawan');
    }
}
