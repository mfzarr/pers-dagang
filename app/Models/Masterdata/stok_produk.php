<?php

namespace App\Models\Masterdata;

use App\Models\Transaksi\Pembeliandetail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Masterdata\Produk;
use App\Models\Transaksi\PenjualanDetail;

class stok_produk extends Model
{
    use HasFactory;

    protected $table ='stok_produk';

    protected $primaryKey = 'id_stok_produk';

    protected $guarded = [];

    public function pembelianDetail()
    {
        return $this->hasMany(Pembeliandetail::class, 'id_stok', 'id_stok');
    }

    public function produkRelation()
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }

    public function penjualanDetail()
    {
        return $this->hasMany(PenjualanDetail::class, 'id_stok', 'id_stok');
    }

}
