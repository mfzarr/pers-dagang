<?php

namespace App\Models\Masterdata;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Masterdata\Perusahaan;
use App\Models\Masterdata\Kategori_barang;
use App\Models\Masterdata\stok_produk;

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

    public function stok_produk()
    {
        return $this->hasMany(stok_produk::class, 'id_produk', 'id_produk');
    }

    
}
