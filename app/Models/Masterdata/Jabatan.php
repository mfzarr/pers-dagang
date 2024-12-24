<?php

namespace App\Models\Masterdata;

use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    protected $table = 'jabatan';
    protected $primaryKey = 'id_jabatan';
    public $timestamps = true;

    protected $fillable = [
        'nama', 'asuransi', 'tarif', 'tarif_tidak_tetap', 'id_perusahaan'
    ];
}

