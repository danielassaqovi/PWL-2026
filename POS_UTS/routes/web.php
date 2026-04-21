<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PosController;
use Illuminate\Support\Facades\Route;

// Halaman utama
Route::get('/', [HomeController::class, 'index'])->name('home');

// POS / Kasir
Route::prefix('pos')->name('pos.')->group(function () {
    Route::get('/', [PosController::class, 'index'])->name('index');
    Route::post('/transaksi', [PosController::class, 'store'])->name('store');
    Route::get('/struk/{kode}', [PosController::class, 'struk'])->name('struk');
});

// Laporan publik
Route::prefix('laporan')->name('laporan.')->group(function () {
    Route::get('/penjualan', [LaporanController::class, 'penjualan'])->name('penjualan');
    Route::get('/stok', [LaporanController::class, 'stok'])->name('stok');
});
