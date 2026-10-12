<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route khusus Dashboard Admin
Route::get('/admin/admin-dashboard', function () {
    return view('admin.admin-dashboard');
})->middleware(['auth'])->name('admin.dashboard');

// Route khusus Dashboard Satpam
Route::get('/satpam/satpam-dashboard', function () {
    return view('satpam.satpam-dashboard');
})->middleware(['auth'])->name('satpam.dashboard');

// Route khusus Dashboard Wali Santri
Route::get('/wali/wali-dashboard', function () {
    return view('wali.wali-dashboard');
})->middleware(['auth'])->name('wali.dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
