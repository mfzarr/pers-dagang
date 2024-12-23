<?php

namespace App\Models\Transaksi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Masterdata\Karyawan;
use App\Models\Masterdata\Produk;

class PenjualanDetail extends Model
{
    use HasFactory;

    protected $table = 'penjualan_detail';
    protected $primaryKey = 'id_penjualan_detail';
    protected $guarded = [];

    /**
     * Relationship with Penjualan.
     */
    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'id_penjualan', 'id_penjualan');
    }

    public function produkRelation()
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }

    public function pegawaiRelation()
    {
        return $this->belongsTo(Karyawan::class, 'id_pegawai', 'id_karyawan');
    }
}
