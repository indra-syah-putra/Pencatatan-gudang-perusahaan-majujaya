<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\LaporanController;

// Redirect root ke dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// ================= LOGIN PORTAL =================
Route::get('/login', function () {
    return redirect()->route('admin.login');
})->name('login');

Route::get('/admin/login', [App\Http\Controllers\Admin\Auth\LoginController::class, 'create'])->name('admin.login');
Route::post('/admin/login', [App\Http\Controllers\Admin\Auth\LoginController::class, 'store'])->middleware('throttle:5,1');

Route::get('/staff/login', [App\Http\Controllers\Staff\Auth\LoginController::class, 'create'])->name('staff.login');
Route::post('/staff/login', [App\Http\Controllers\Staff\Auth\LoginController::class, 'store'])->middleware('throttle:5,1');

// ================= GROUP: AUTH (SEMUA USER LOGIN) =================
Route::middleware(['auth'])->group(function () {
    
    // 0. Profile
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');

    // 0. Settings (Admin only)
    Route::get('/settings', [App\Http\Controllers\SettingsController::class, 'index'])->name('settings.index')->middleware('is_admin');
    Route::put('/settings', [App\Http\Controllers\SettingsController::class, 'update'])->name('settings.update')->middleware('is_admin');

    // 1. Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // 2. Data Barang (CRUD) - KHUSUS ADMIN
    Route::resource('barang', BarangController::class)->middleware('is_admin');

    // 3. Transaksi (Input Stok)
    Route::get('/transaksi/create', [TransaksiController::class, 'create'])->name('transaksi.create');
    Route::post('/transaksi', [TransaksiController::class, 'store'])->name('transaksi.store')->middleware('throttle:30,1');
    // 4. Laporan (Cetak Invoice)
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
});

// Auth Routes
require __DIR__.'/auth.php';