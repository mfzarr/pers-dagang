<?php

namespace App\Models\Masterdata;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $table = 'supplier'; // maps to 'supplier' table

    protected $primaryKey = 'id_supplier'; // set the primary key

    protected $fillable = ['nama', 'alamat', 'no_telp', 'id_perusahaan'];

    public $timestamps = true; // uses created_at and updated_at columns
}
