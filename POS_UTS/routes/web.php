<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StrukController;
use App\Http\Controllers\PosController;

// Redirect root to admin dashboard
Route::get('/', function () {
    return redirect('/admin');
});

Route::get('/pos/struk/{kode}', [StrukController::class, 'cetak'])->name('pos.struk');

Route::get('/pos', [PosController::class, 'index'])->name('pos.index');
Route::post('/pos/store', [PosController::class, 'store'])->name('pos.store');

