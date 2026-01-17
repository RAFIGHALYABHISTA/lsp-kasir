<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/create', [AdminController::class, 'create'])->name('admin.create');
    Route::post('/admin', [AdminController::class, 'store'])->name('admin.store');
    Route::get('/admin/{barang}/edit', [AdminController::class, 'edit'])->name('admin.edit');
    Route::put('/admin/{barang}', [AdminController::class, 'update'])->name('admin.update');
    Route::delete('/admin/{barang}', [AdminController::class, 'destroy'])->name('admin.destroy');
});

Route::get('/', [KasirController::class, 'index']);

Route::get('/kasir', [KasirController::class, 'index'])->name('kasir.index');
Route::post('/kasir/tambah', [KasirController::class, 'tambah'])->name('kasir.tambah');
Route::post('/kasir/simpan', [KasirController::class, 'simpan'])->name('kasir.simpan');
Route::delete('/kasir/hapus/{id}', [KasirController::class, 'hapus'])->name('kasir.hapus');
Route::get('/kasir/invoice/{id}', [KasirController::class, 'invoice'])->name('kasir.invoice');