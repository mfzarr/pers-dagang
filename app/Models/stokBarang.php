<?php

namespace App\Models;

use App\Models\Transaksi\Pembeliandetail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class stokBarang extends Model
{
    use HasFactory;

    protected $table = "stok_barang";

    protected $guarded = ["id"];

    public function pembelianDetail() {
        return $this->belongsTo(Pembeliandetail::class);
    }
}
