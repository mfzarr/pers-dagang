<?php

namespace App\Models\Transaksi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelunasanPembelian extends Model
{
    use HasFactory;

    protected $table = 'pelunasan_pembelian'; // Match the table name in the database

    protected $fillable = [
        'id_pembelian',
        'id_barang',
        'total_pelunasan',
        'tanggal_pelunasan'
    ];

    // Relationship with Pembelian
    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class, 'id_pembelian');
    }
}
