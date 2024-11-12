<?php

namespace App\Models\Masterdata;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jasadetail extends Model
{
    use HasFactory;
    protected $table = 'jasa_detail';

    protected $primaryKey = 'id_jasa_detail';

    protected $guarded = [];
}
