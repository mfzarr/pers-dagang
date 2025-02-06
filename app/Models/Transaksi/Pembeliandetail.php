<?php

namespace App\Models\Transaksi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Masterdata\Produk;
use App\Models\Laporan\StokProduk;

class Pembeliandetail extends Model
{
    use HasFactory;

    protected $table = 'pembelian_detail';
    protected $primaryKey = 'id_pembelian_detail';
    protected $guarded = [];

    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class, 'id_pembelian');
    }

    public function produkRelation()
    {
        return $this->belongsTo(Produk::class, 'id_produk');
    }

    public function stokProduk()
{
    return $this->hasOne(StokProduk::class, 'id_pembelian_detail', 'id_pembelian_detail');
}

}
