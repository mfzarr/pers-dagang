<?php

namespace App\Models\Transaksi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Masterdata\Supplier;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use App\Models\laporan\GeneralLedger;

class Pembelian extends Model
{
    use HasFactory;

    protected $table = 'pembelian';
    protected $primaryKey = 'id_pembelian';
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($pembelian) {
            $date = Carbon::now()->format('Ymd');

            // Set default id to 1 if no record exists yet
            $nextId = self::max('id_pembelian') ? self::max('id_pembelian') + 1 : 1;
            $formattedId = str_pad($nextId, 4, '0', STR_PAD_LEFT);

            $pembelian->no_transaksi_pembelian = "PBL/{$date}/{$formattedId}";
        });
    }

    // In Pembelian.php model
    public function supplierRelation()
    {
        return $this->belongsTo(Supplier::class, 'supplier', 'id_supplier');
    }

    public function pelunasanPembelian()
    {
        return $this->hasMany(PelunasanPembelian::class, 'id_pembelian');
    }

    public function pembelianDetails()
    {
        return $this->hasMany(Pembeliandetail::class, 'id_pembelian', 'id_pembelian');
    }
}
