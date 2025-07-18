<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ManajemenKaryawanController;
use App\Http\Controllers\Admin\ManajemenPenggunaController;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ManajemenTugasController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

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
});

Route::get('/get-data', function () {
    $data = User::select('*');
    return response()->json($data);
});

Route::get('/template', function () {
    return view('template.dashboard');
});

Route::get('/search-karyawan', [AjaxController::class, 'getKaryawan'])->name('search.karyawan');
