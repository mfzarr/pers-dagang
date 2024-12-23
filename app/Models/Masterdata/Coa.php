<?php

namespace App\Models\Masterdata;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Masterdata\CoaKelompok;
use App\Models\Laporan\JurnalUmum;

class Coa extends Model
{
    use HasFactory;

    // Table name
    protected $table = 'coa';

    // Primary key
    protected $primaryKey = 'id_coa';

    // If primary key is not auto-incrementing, specify this
    public $incrementing = true;

    // Data type of the primary key
    protected $keyType = 'int';

    // Fillable columns for mass assignment
    protected $fillable = [
        'kode_akun',
        'nama_akun',
        'kelompok_akun',
        'posisi_d_c',
        'saldo_awal',
        'id_perusahaan',
    ];

    // Disable timestamps if not present in the table
    public $timestamps = false;

    /**
     * Define a many-to-one relationship with CoaKelompok
     * (Each Coa belongs to one CoaKelompok)
     */
    public function kelompokakun()
    {
        return $this->belongsTo(CoaKelompok::class, 'kelompok_akun', 'kelompok_akun');
    }

    /**
     * Define a many-to-one relationship with Perusahaan
     * Uncomment if you need it in the future.
     */
    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class, 'id_perusahaan', 'id_perusahaan');
    }

    public function jurnalUmums()
    {
        return $this->hasMany(JurnalUmum::class, 'id_coa', 'id_coa');
    }
}
