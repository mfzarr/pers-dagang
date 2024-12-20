<?php

namespace App\Models\Masterdata;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori_barang extends Model
{
    use HasFactory;

    protected $table = 'kategori_barang'; // maps to 'kategori_barang' table

    protected $primaryKey = 'id_kategori_barang'; // set the primary key

    protected $fillable = [
        'nama',
        'id_perusahaan',
    ]; // mass-assignable attributes

    public $timestamps = true; // if you are using created_at and updated_at columns

    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class, 'id_perusahaan');
    }
    
}
