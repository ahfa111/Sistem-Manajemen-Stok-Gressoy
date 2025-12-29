<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\BahanBakuController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PengaturanController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Public Routes (Auth)
Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/register', [AuthController::class, 'register']);

// Protected Routes (Sanctum Middleware)
Route::middleware('auth:sanctum')->group(function () {
    
    // User Info
    Route::get('/auth/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/auth/logout', [AuthController::class, 'logout']);

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // Core Features
    Route::get('/keuangan', [KeuanganController::class, 'index']);
    Route::get('/bahan-baku', [BahanBakuController::class, 'index']);
    
    // Laporan Resource
    Route::get('/laporan', [LaporanController::class, 'index']);
    Route::post('/laporan', [LaporanController::class, 'store']);
    Route::put('/laporan/{id}', [LaporanController::class, 'update']);
    Route::delete('/laporan/{id}', [LaporanController::class, 'destroy']);

    // Pengaturan
    Route::prefix('pengaturan')->group(function () {
        Route::get('/', [PengaturanController::class, 'index']);
        Route::put('/profil', [PengaturanController::class, 'updateProfile']);
        Route::put('/perusahaan', [PengaturanController::class, 'updateCompany']);
        Route::put('/notifikasi', [PengaturanController::class, 'updateNotifications']);
        Route::put('/password', [PengaturanController::class, 'updatePassword']);
        Route::delete('/delete-account', [PengaturanController::class, 'deleteAccount']);
    });

    // User Management (Admin)
    Route::get('/users', [App\Http\Controllers\ManajemenUserController::class, 'index']);
    Route::post('/users', [App\Http\Controllers\ManajemenUserController::class, 'store']);
    Route::put('/users/{id}', [App\Http\Controllers\ManajemenUserController::class, 'update']);
    Route::delete('/users/{id}', [App\Http\Controllers\ManajemenUserController::class, 'destroy']);

    // Supplier Management
    Route::get('/suppliers', [App\Http\Controllers\SupplierController::class, 'index']);
    Route::get('/suppliers/{id}', [App\Http\Controllers\SupplierController::class, 'show']);
    Route::post('/suppliers', [App\Http\Controllers\SupplierController::class, 'store']);
    Route::put('/suppliers/{id}', [App\Http\Controllers\SupplierController::class, 'update']);
    Route::delete('/suppliers/{id}', [App\Http\Controllers\SupplierController::class, 'destroy']);
});
