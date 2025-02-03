<?php
namespace App\Models\Transaksi;

use App\Models\Masterdata\Karyawan;
use App\Models\Perusahaan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class presensi extends Model
{
    use HasFactory;

    protected $table = 'presensi';
    protected $primaryKey = 'id_presensi';
    
    protected $fillable = [
        'id_karyawan', 'tanggal_presensi', 'status', 'id_perusahaan','jam_masuk','jam_keluar',
    ];

    // Relationship: A Presensi belongs to a Karyawan
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan');
    }

    // Relationship with Perusahaan
    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class, 'id_perusahaan');
    }

}
