<?php

namespace App\Models\Transaksi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Masterdata\Coa;

class Beban extends Model
{
    use HasFactory;

    protected $table = 'pengeluaran_beban';

    protected $primaryKey = 'id_beban'; // Specify the primary key

    protected $fillable = [
        'nama_beban',
        'harga',
        'tanggal',
        'id_perusahaan',
        'id_coa',
    ];

    public function coa()
    {
        return $this->belongsTo(Coa::class, 'id_coa', 'id_coa');
    }
}

