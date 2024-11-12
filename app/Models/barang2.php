<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang2 extends Model
{
    protected $table = 'barang'; // Sesuaikan nama tabel di sini

    protected $primaryKey = 'id_barang';

    protected $fillable = [
        'nama',
        'detail',
        'satuan',
        'harga_jual',
        'HPP',
        'id_perusahaan',
    ];
}
