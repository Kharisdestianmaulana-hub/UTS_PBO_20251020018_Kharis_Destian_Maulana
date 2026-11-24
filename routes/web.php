<?php

use App\Http\Controllers\InventarisController;
use Illuminate\Support\Facades\Route;

// Arahkan halaman utama langsung ke daftar inventaris.
Route::redirect('/', '/inventaris');

// 7 Route CRUD Inventaris (urutan statis /create sebelum dinamis /{kode}).
Route::get('/inventaris', [InventarisController::class, 'index'])->name('inventaris.index');
Route::get('/inventaris/create', [InventarisController::class, 'create'])->name('inventaris.create');
Route::post('/inventaris', [InventarisController::class, 'store'])->name('inventaris.store');
Route::get('/inventaris/{kode}', [InventarisController::class, 'show'])->name('inventaris.show');
Route::get('/inventaris/{kode}/edit', [InventarisController::class, 'edit'])->name('inventaris.edit');
Route::match(['put', 'patch'], '/inventaris/{kode}', [InventarisController::class, 'update'])->name('inventaris.update');
Route::delete('/inventaris/{kode}', [InventarisController::class, 'destroy'])->name('inventaris.destroy');
