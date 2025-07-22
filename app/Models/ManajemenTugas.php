<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManajemenTugas extends Model
{
    use HasFactory;

    protected $table = 'manajemen_tugas';

    protected $guarded = ['id'];

    public function status()
    {
        return $this->belongsTo(StatusTugas::class, 'status_tugas_id');
    }

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'karyawan_id');
    }
}
