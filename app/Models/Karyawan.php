<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;

    protected $table = 'karyawan';

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function manajemenTugas()
    {
        return $this->hasMany(ManajemenTugas::class, 'karyawan_id', 'id');
    }

    public function dataAbsensi()
    {
        return $this->hasMany(DataKaryawanAbsen::class, 'karyawan_id', 'id');
    }
}
