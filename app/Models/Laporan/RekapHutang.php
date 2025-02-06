<?php
namespace App\Models\Laporan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Transaksi\Pembelian;
use App\Models\Masterdata\Supplier;

class RekapHutang extends Model
{
    use HasFactory;

    protected $table = 'rekap_hutang';
    protected $primaryKey = 'id'; // Primary key set to 'id' as in the migration
    public $incrementing = true; // Ensure primary key is auto-incrementing

    protected $fillable = [
        'pembelian_id',
        'id_supplier',
        'total_hutang',
        'total_dibayar',
        'sisa_hutang',
        'tenggat_pelunasan'
    ];

    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class, 'pembelian_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'id_supplier');
    }
}
