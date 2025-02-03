<?php

namespace App\Models\Masterdata;

use App\Models\Masterdata\Produk;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supplier extends Model
{
    use HasFactory;

    protected $table = 'supplier'; // maps to 'supplier' table

    protected $primaryKey = 'id_supplier'; // set the primary key

    protected $fillable = [
        'nama',
        'alamat',
        'no_telp',
        'status',
        'id_perusahaan',
    ]; // mass-assignable fields

    public $timestamps = true; // uses created_at and updated_at columns

    public function products()
    {
        return $this->belongsToMany(Produk::class, 'produk_supplier', 'id_supplier', 'id_produk');
    }
}
