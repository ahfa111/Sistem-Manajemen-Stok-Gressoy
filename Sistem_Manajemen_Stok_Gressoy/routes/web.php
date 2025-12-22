<?php

use Illuminate\Support\Facades\Route;
<<<<<<< HEAD
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index']);
=======
use App\Http\Controllers\KeuanganController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/keuangan', [KeuanganController::class, 'index'])->name('keuangan.index');

Route::post('/keuangan/tambah', [KeuanganController::class, 'tambahTransaksi'])->name('keuangan.tambah');

Route::get('/bahan-baku', function () {
    return view('bahan-baku.index');
})->name('bahan-baku');

Route::get('/laporan', function () {
    return view('laporan.index');
})->name('laporan');

Route::get('/pengaturan', function () {
    return view('pengaturan.index');
})->name('pengaturan');

Route::post('/logout', function () {
    // Auth::logout();
    // session()->invalidate();
    // session()->regenerateToken();
    return redirect('/');
})->name('logout');
>>>>>>> fbfa846c12c7d64f0e72f228a000b8b5f80abc6c
