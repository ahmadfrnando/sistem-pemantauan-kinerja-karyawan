<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluasiKinerjaKaryawan extends Model
{
    use HasFactory;

    protected $table = 'evaluasi_kinerja_karyawan';
    protected $guarded = ['id'];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'karyawan_id');
    }

    public function evaluasiKinerja()
    {
        return $this->belongsTo(EvaluasiKinerja::class, 'evaluasi_kinerja_id');
    }
}
