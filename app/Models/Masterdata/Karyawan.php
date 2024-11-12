<?php

namespace App\Models\Masterdata;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;

    protected $table = 'karyawan';

    protected $primaryKey = 'id_karyawan';

    protected $fillable = [
        'nama', 'no_telp', 'jenis_kelamin', 'email', 'alamat', 'status', 'id_jabatan', 'id_perusahaan', 'id_user'
    ];

    public $timestamps = true;

    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class, 'id_perusahaan');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
