<?php

namespace App\Models\Masterdata;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    protected $table = 'assets';
    protected $primaryKey = 'id_assets';
    protected $fillable = [
        'nama_asset',
        'harga_perolehan',
        'nilai_sisa',
        'masa_manfaat',
        'id_perusahaan',
    ];

    protected $casts = [
        'harga_perolehan' => 'float',
        'nilai_sisa' => 'float',
        'masa_manfaat' => 'integer',
    ];

    public function getDepreciationPerYearAttribute()
    {
        if ($this->masa_manfaat > 0) {
            return ($this->harga_perolehan - $this->nilai_sisa) / $this->masa_manfaat;
        }
        return 0;
    }

    public function calculateDepreciationSchedule()
    {
        $penyusutan_per_tahun = $this->depreciation_per_year;
        $akumulasi_penyusutan = 0;
        $nilai_buku = $this->harga_perolehan;

        $schedule = [];
        for ($year = 1; $year <= $this->masa_manfaat; $year++) {
            $akumulasi_penyusutan += $penyusutan_per_tahun;
            $nilai_buku -= $penyusutan_per_tahun;

            $schedule[] = [
                'tahun' => $year,
                'biaya_penyusutan' => $penyusutan_per_tahun,
                'akumulasi_penyusutan' => $akumulasi_penyusutan,
                'nilai_buku' => max($nilai_buku, $this->nilai_sisa),
            ];
        }
        return $schedule;
    }
}
