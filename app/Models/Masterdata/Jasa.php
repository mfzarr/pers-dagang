<?php

namespace App\Models\Masterdata;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jasa extends Model
{
    use HasFactory;

    protected $table = 'jasa';
    protected $primaryKey = 'id_jasa';
    protected $fillable = ['nama', 'detail', 'harga', 'id_perusahaan'];
    public $timestamps = true;
}
