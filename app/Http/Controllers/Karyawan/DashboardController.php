<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use App\Models\ManajemenTugas;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke()
    {   
        $karyawan = Karyawan::where('user_id', auth()->user()->id)->first();
        $tugas = ManajemenTugas::where('karyawan_id', $karyawan->id)->get();
        return view('pages.karyawan.dashboard', compact('tugas'));
    }
}
