<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ManajemenEvaluasiKinerja;
use App\Http\Controllers\Admin\ManajemenEvaluasiKinerjaController;
use App\Http\Controllers\Admin\ManajemenKaryawanController;
use App\Http\Controllers\Admin\ManajemenPenggunaController;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\Karyawan\DaftarTugasController as KaryawanDaftarTugasController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ManajemenTugasController;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Karyawan\DashboardController as KaryawanDashboardController;
use App\Http\Controllers\Karyawan\RiwayatTugasController as KaryawanRiwayatTugasController;
use App\Http\Controllers\Karyawan\AbsensiHarianController as KaryawanAbsensiHarianController;
use App\Models\DataKaryawanAbsen;
use App\Models\ManajemenTugas;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['web'])->group(function () {
    // route yang ada
    Route::get('/', [LoginController::class, 'showLoginForm'])->name('home');
});

Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});

Route::get('/', [LoginController::class, 'showLoginForm'])->name('home');
Route::post('/', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'role:admin'])->name('admin.')->prefix('admin')->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::resource('/manajemen-pengguna', ManajemenPenggunaController::class);
    Route::resource('/manajemen-karyawan', ManajemenKaryawanController::class);
    Route::resource('/manajemen-tugas', ManajemenTugasController::class);
    Route::resource('/manajemen-evaluasi-kinerja', ManajemenEvaluasiKinerjaController::class);
    Route::post('/manajemen-evaluasi-kinerja/regenerate/{id_evaluasi}', [ManajemenEvaluasiKinerjaController::class, 'generateEvaluasi'])->name('manajemen-evaluasi-kinerja.regenerate');
});

Route::middleware(['auth', 'role:karyawan'])->name('karyawan.')->prefix('karyawan')->group(function () {
    Route::get('/dashboard', KaryawanDashboardController::class)->name('dashboard');
    Route::resource('/daftar-tugas', KaryawanDaftarTugasController::class);
    Route::put('/daftar-tugas/{jenis}/{id?}', [KaryawanDaftarTugasController::class, 'updateTugas'])->name('daftar-tugas.update-tugas');
    Route::resource('/riwayat-tugas', KaryawanRiwayatTugasController::class);
    Route::resource('/absensi-harian', KaryawanAbsensiHarianController::class);
});

Route::get('/get-data', function () {
    $today = Carbon::today();

    $startDate = $today->subDays(6);
    $endDate = $today;

    $dataAbsensi = DB::table('data_karyawan_absen')
        ->whereBetween('tanggal', [$startDate, $endDate])
        ->select(DB::raw('DAYOFWEEK(tanggal) as day, COUNT(*) as total_kehadiran'))
        ->groupBy(DB::raw('DAYOFWEEK(tanggal)'))
        ->get();
    return response()->json($dataAbsensi);
});

Route::get('/template', function () {
    return view('template.dashboard');
});

Route::get('/search-karyawan', [AjaxController::class, 'getKaryawan'])->name('search.karyawan');
