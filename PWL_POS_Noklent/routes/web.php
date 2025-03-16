<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\StockController;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('level')->group(function () {
    Route::get('/', [LevelController::class, 'index']);
    Route::get('/tambah', [LevelController::class, 'tambah']) ;
    Route::post('/tambah_simpan', [LevelController::class, 'tambah_simpan']);
    Route::get('/ubah/{id}', [LevelController::class, 'edit']);
    Route::put('/ubah_simpan/{id}', [LevelController::class, 'ubah_simpan']);
    Route::get('/hapus/{id}', [LevelController::class, 'hapus']);
});

Route::prefix('user')->group(function () {
    Route::get('/', [UserController::class, 'index']);
    Route::get('/tambah', [UserController::class, 'tambah']);
    Route::post('/tambah_simpan', [UserController::class, 'tambah_simpan']); //store
    Route::get('/ubah/{id}', [UserController::class, 'edit']);
    Route::put('/ubah_simpan/{id}', [UserController::class, 'ubah_simpan']);
    Route::get('/hapus/{id}', [UserController::class, 'hapus']);
});

Route::prefix('kategori')->group(function () {
    Route::get('/', [KategoriController::class, 'index'])->name('kategori.index');
    Route::get('/create', [KategoriController::class, 'create'])->name('kategori.create');
    Route::post('/', [KategoriController::class, 'store'])->name('kategori.store');
    Route::get('/edit/{id}', [KategoriController::class, 'edit'])->name('kategori.edit');
    Route::put('/update/{id}', [KategoriController::class, 'update'])->name('kategori.update');
    Route::delete('/delete/{id}', [KategoriController::class, 'destroy'])->name('kategori.destroy');
});

Route::prefix('barang')->group(function () {
    Route::get('/', [BarangController::class, 'index'])->name('barang.index');
    Route::get('/create', [BarangController::class, 'create'])->name('barang.create');
    Route::post('/', [BarangController::class, 'store'])->name('barang.store');
    Route::get('/edit/{id}', [BarangController::class, 'edit'])->name('barang.edit');
    Route::put('/update/{id}', [BarangController::class, 'update'])->name('barang.update');
    Route::delete('/delete/{id}', [BarangController::class, 'destroy'])->name('barang.destroy');
});
Route::prefix('stock')->group(function () {
    Route::get('/', [StockController::class, 'index'])->name('stock.index');
    Route::get('/create', [StockController::class, 'create'])->name('stock.create');
    Route::post('/', [StockController::class, 'store'])->name('stock.store');
    Route::get('/edit/{id}', [StockController::class, 'edit'])->name('stock.edit');
    Route::put('/update/{id}', [StockController::class, 'update'])->name('stock.update');
    Route::delete('/delete/{id}', [StockController::class, 'destroy'])->name('stock.destroy');
});
