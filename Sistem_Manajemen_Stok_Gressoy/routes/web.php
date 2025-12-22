<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BahanBakuController;
use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KeuanganController;

Route::get('/keuangan', [KeuanganController::class, 'index'])
    ->name('keuangan.index');
    
Route::prefix('keuangan')->middleware('auth')->group(function () {
    Route::get('/', [KeuanganController::class, 'index'])->name('keuangan.index');
    Route::post('/store', [KeuanganController::class, 'store'])->name('keuangan.store');
    Route::put('/{id}', [KeuanganController::class, 'update'])->name('keuangan.update');
    Route::delete('/{id}', [KeuanganController::class, 'destroy'])->name('keuangan.destroy');
});


Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

Route::get('/register', [AuthController::class, 'registerForm'])
    ->name('register');

Route::post('/register', [AuthController::class, 'register'])
    ->name('register.store');

// Homepage
Route::get('/', function () {
    return view('welcome');
});

// Login
Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);


// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

Route::prefix('laporan')->name('laporan.')->group(function () {
    Route::get('/', [LaporanController::class, 'index'])->name('index');
    Route::post('/', [LaporanController::class, 'store'])->name('store');
    Route::put('/{id}', [LaporanController::class, 'update'])->name('update');
    Route::delete('/{id}', [LaporanController::class, 'destroy'])->name('destroy');
});

Route::prefix('bahan-baku')->name('bahan-baku.')->group(function () {
    Route::get('/', [BahanBakuController::class, 'index'])->name('index');
    Route::post('/', [BahanBakuController::class, 'store'])->name('store');
    Route::put('/{id}', [BahanBakuController::class, 'update'])->name('update');
    Route::delete('/{id}', [BahanBakuController::class, 'destroy'])->name('destroy');
    Route::post('/tambah-stok', [BahanBakuController::class, 'tambahStok'])->name('tambahStok');
    Route::post('/kurang-stok', [BahanBakuController::class, 'kurangStok'])->name('kurangStok');
});

Route::prefix('pengaturan')->name('pengaturan.')->group(function () {
    Route::get('/', [App\Http\Controllers\PengaturanController::class, 'index'])->name('index');
    Route::put('/profil', [App\Http\Controllers\PengaturanController::class, 'updateProfile'])->name('updateProfile');
    Route::put('/perusahaan', [App\Http\Controllers\PengaturanController::class, 'updateCompany'])->name('updateCompany');
    Route::put('/notifikasi', [App\Http\Controllers\PengaturanController::class, 'updateNotifications'])->name('updateNotifications');
    Route::put('/password', [App\Http\Controllers\PengaturanController::class, 'updatePassword'])->name('updatePassword');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');


Route::get('/', function () {
    return view('home');
})->name('home');
