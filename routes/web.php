<?php

use App\Http\Controllers\AdminPerizinanController;
use App\Http\Controllers\AdminSantriController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SatpamAbsensiController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/admin-dashboard', [DashboardController::class, 'admin'])->name('dashboard');
    Route::resource('santris', AdminSantriController::class)->except(['show']);
    Route::get('/perizinans', [AdminPerizinanController::class, 'index'])->name('perizinans.index');
    Route::post('/perizinans', [AdminPerizinanController::class, 'store'])->name('perizinans.store');
    Route::patch('/perizinans/{perizinan}', [AdminPerizinanController::class, 'update'])->name('perizinans.update');
});

Route::middleware(['auth', 'role:satpam'])->prefix('satpam')->name('satpam.')->group(function () {
    Route::get('/satpam-dashboard', [SatpamAbsensiController::class, 'index'])->name('dashboard');
    Route::post('/absensi', [SatpamAbsensiController::class, 'store'])->name('absensi.store');
});

Route::get('/wali/wali-dashboard', [DashboardController::class, 'wali'])
    ->middleware(['auth', 'role:wali_santri'])
    ->name('wali.dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
