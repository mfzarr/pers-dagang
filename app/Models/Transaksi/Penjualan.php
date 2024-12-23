<?php

namespace App\Models\Transaksi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Masterdata\Pelanggan;
use App\Models\Masterdata\Karyawan;
use App\Models\Masterdata\User;
use app\Models\Masterdata\Coa;
use App\Models\Transaksi\PenjualanDetail;
use Carbon\Carbon;

class Penjualan extends Model
{
    use HasFactory;

    protected $table = 'penjualan';
    protected $primaryKey = 'id_penjualan';
    protected $guarded = [];

    /**
     * Boot the model to auto-generate `no_transaksi_penjualan`.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($penjualan) {
            $date = Carbon::now()->format('Ymd'); // Get current date

            // Get the next available ID or default to 1 if no record exists
            $nextId = self::max('id_penjualan') ? self::max('id_penjualan') + 1 : 1;

            // Format the ID to 4 digits with leading zeros
            $formattedId = str_pad($nextId, 4, '0', STR_PAD_LEFT);

            // Generate the transaction number in the required format
            $penjualan->no_transaksi_penjualan = "PJL/{$date}/{$formattedId}";
        });
    }

    /**
     * Relationship with PenjualanDetail.
     */
    public function penjualanDetails()
    {
        return $this->hasMany(PenjualanDetail::class, 'id_penjualan', 'id_penjualan');
    }

    /**
     * Relationship with Pelanggan (Customer).
     */
    public function pelangganRelation()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan', 'id_pelanggan');
    }

    /**
     * Relationship with Karyawan (Employee).
     */
    public function pegawaiRelation()
    {
        return $this->belongsTo(Karyawan::class, 'id_pegawai', 'id_karyawan');
    }

    public function userRelation()
    {
        return $this->belongsTo(User::class, 'id', 'id');
    }

    public function coa()
    {
        return $this->belongsTo(Coa::class, 'id_perusahaan', 'id_perusahaan');
    }
}
