<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;

//auth admin dan kasir
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout-success', [AuthController::class, 'logoutSuccess'])->name('logout.success');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/create', [AdminController::class, 'create'])->name('admin.create');
    Route::post('/admin', [AdminController::class, 'store'])->name('admin.store');
    Route::get('/admin/{barang}/edit', [AdminController::class, 'edit'])->name('admin.edit');
    Route::put('/admin/{barang}', [AdminController::class, 'update'])->name('admin.update');
    Route::delete('/admin/{barang}', [AdminController::class, 'destroy'])->name('admin.destroy');

    // routes for KasirController
    Route::get('/admin/kasir', [KasirController::class, 'index'])->name('admin.kasir');
    Route::post('/admin/kasir/tambah', [KasirController::class, 'tambah'])->name('admin.kasir.tambah');
    Route::post('/admin/kasir/simpan', [KasirController::class, 'simpan'])->name('admin.kasir.simpan');
    Route::delete('/admin/kasir/hapus/{id}', [KasirController::class, 'hapus'])->name('admin.kasir.hapus');
    Route::get('/admin/kasir/invoice/{id}', [KasirController::class, 'invoice'])->name('admin.kasir.invoice');

    Route::get('/admin/inventory', [AdminController::class, 'inventory'])->name('admin.inventory');
    Route::get('/admin/inventory/export', [AdminController::class, 'exportInventory'])->name('admin.inventory.export');
    Route::get('/admin/laporan', [AdminController::class, 'laporan'])->name('admin.laporan');
    Route::delete('/admin/laporan/{transaksi}', [AdminController::class, 'destroyTransaksi'])->name('admin.laporan.destroy');

    // Customer routes
    Route::get('/admin/customers', [AdminController::class, 'customers'])->name('admin.customers');
    Route::get('/admin/customers/create', [AdminController::class, 'createCustomer'])->name('admin.customers.create');
    Route::post('/admin/customers', [AdminController::class, 'storeCustomer'])->name('admin.customers.store');
    Route::get('/admin/customers/{customer}/edit', [AdminController::class, 'editCustomer'])->name('admin.customers.edit');
    Route::put('/admin/customers/{customer}', [AdminController::class, 'updateCustomer'])->name('admin.customers.update');
    Route::delete('/admin/customers/{customer}', [AdminController::class, 'destroyCustomer'])->name('admin.customers.destroy');
});

Route::get('/', function () {
    if (auth()->check()) {
        $user = auth()->user();
        if ($user->role === 'admin') {
            return redirect('/admin');
        } elseif ($user->role === 'kasir') {
            return redirect('/admin/kasir');
        }
    }
    return redirect()->route('login');
});