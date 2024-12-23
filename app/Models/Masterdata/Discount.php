<?php

namespace App\Models\Masterdata;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    protected $table = 'discounts';

    protected $primaryKey = 'id_discount';

    protected $fillable = [
        'min_transaksi',
        'discount_percentage',
        'id_perusahaan',
    ];
    
    public $timestamps = true; // Auto update created_at and updated_at

    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class, 'id_perusahaan');
    }
}
