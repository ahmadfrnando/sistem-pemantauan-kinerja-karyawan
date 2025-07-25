<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataKaryawanAbsen extends Model
{
    use HasFactory;

    protected $table = 'data_karyawan_absen';

    protected $guarded = [];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'karyawan_id', 'id');
    }
}
