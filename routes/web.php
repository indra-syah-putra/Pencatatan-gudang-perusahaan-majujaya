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

// ================= GROUP: KHUSUS ADMIN (FULL ACCESS) =================
// Di sini Admin punya akses ke SEMUANYA (Barang, Transaksi, Laporan, Dashboard)
Route::middleware(['auth'])->group(function () {
    
    // 1. Dashboard (Sekarang khusus Admin)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // 2. Data Barang (CRUD)
    Route::resource('barang', BarangController::class);

    // 3. Transaksi (Input Stok)
    Route::get('/transaksi/create', [TransaksiController::class, 'create'])->name('transaksi.create');
    Route::post('/transaksi', [TransaksiController::class, 'store'])->name('transaksi.store');

    // 4. Laporan (Cetak Invoice)
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
});

// ================= GROUP: KHUSUS STAFF (AKSES TERBATAS) =================
// Jika Anda ingin Staff tetap punya halaman sendiri, tambahkan di sini.
// Jika kosong, Staff tidak akan punya akses ke halaman sistem manapun.
Route::middleware(['auth'])->group(function () {
    // Contoh: Halaman Staff khusus jika diperlukan
    // Route::view('/staff-only', 'staff-only')->name('staff.home');
});

// Auth Routes
require __DIR__.'/auth.php';