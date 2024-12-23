<?php

namespace App\Models\Masterdata;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';

    protected $primaryKey = 'id_produk';

    protected $fillable = [
        'nama', 'id_kategori_barang', 'stok', 'harga', 'hpp', 'status', 'id_perusahaan'
    ];
    
    

    public $timestamps = true;

    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class, 'id_perusahaan');
    }

    public function kategori_barang()
    {
        return $this->belongsTo(Kategori_barang::class, 'id_kategori_barang');
    }
}
