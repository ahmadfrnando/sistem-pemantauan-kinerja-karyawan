<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;

    protected $table = 'karyawan';

    protected $guarded = ['id'];


    protected static function boot()
    {
        parent::boot();

        static::created(function ($item) {
            $user = User::create([
                'name' => $item->nama,
                'username' => str_replace(' ', '', $item->nama) . $item->id,
                'password' => bcrypt('123'),
                'role' => 'karyawan',
            ]);
            $item->update(['user_id' => $user->id]);
        });
    }

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
