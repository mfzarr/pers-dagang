<?php

namespace App\Models\Masterdata;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;

    protected $table = 'pelanggan'; // maps to 'pelanggan' table

    protected $primaryKey = 'id_pelanggan'; // set the primary key

    protected $fillable = ['nama', 'email', 'no_telp', 'alamat', 'id_perusahaan'];

    public $timestamps = true; // if you are using created_at and updated_at columns

    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class, 'id_perusahaan');
    }
}
