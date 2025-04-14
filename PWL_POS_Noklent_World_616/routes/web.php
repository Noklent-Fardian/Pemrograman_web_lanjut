<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\LandingController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [LandingController::class, 'index']);
Route::pattern('id', '[0-9]+');
Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'postLogin'])->name('postLogin');
Route::get('logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
Route::get('register', [AuthController::class, 'register'])->name('register');
Route::post('register', [AuthController::class, 'postRegister'])->name('postRegister');


Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [WelcomeController::class, 'index']);

    // ADMIN ONLY ROUTES
    // User and Level Management - Admin only
    Route::prefix('user')->middleware(['authorize:ADM'])->group(function () {
        Route::get('/', [UserController::class, 'index']);
        Route::get('/list', [UserController::class, 'list']);
        Route::get('/create', [UserController::class, 'create']);
        Route::post('/', [UserController::class, 'store']);
        Route::post('/store', [UserController::class, 'store']);
        Route::get('/show/{id}', [UserController::class, 'show']);
        Route::get('/edit/{id}', [UserController::class, 'edit']);
        Route::put('/update/{id}', [UserController::class, 'update']);
        Route::delete('/delete/{id}', [UserController::class, 'delete']);
        Route::get('/create_ajax', [UserController::class, 'create_ajax']);
        Route::post('/ajax', [UserController::class, 'store_ajax']);
        Route::get('/{id}/edit_ajax', [UserController::class, 'edit_ajax']);
        Route::put('/{id}/update_ajax', [UserController::class, 'update_ajax']);
        Route::get('/{id}/delete_ajax', [UserController::class, 'confirm_ajax']);
        Route::delete('/{id}/delete_ajax', [UserController::class, 'delete_ajax']);
        Route::get('/show_ajax/{id}', [UserController::class, 'showAjax']);
        Route::get('/import', [UserController::class, 'import']);
        Route::post('/import_ajax', [UserController::class, 'import_ajax']);
        Route::get('export_excel', [UserController::class, 'export_excel']);
        Route::get('/export_pdf', [UserController::class, 'export_pdf']);
  

    });

    Route::prefix('level')->middleware(['authorize:ADM'])->group(function () {
        Route::get('/', [LevelController::class, 'index']);
        Route::get('/list', [LevelController::class, 'list']);
        Route::get('/create', [LevelController::class, 'create']);
        Route::post('/', [LevelController::class, 'store']);
        Route::post('/store', [LevelController::class, 'store']);
        Route::get('/show/{id}', [LevelController::class, 'show']);
        Route::get('/edit/{id}', [LevelController::class, 'edit']);
        Route::put('/update/{id}', [LevelController::class, 'update']);
        Route::delete('/delete/{id}', [LevelController::class, 'delete']);
        Route::get('/create_ajax', [LevelController::class, 'create_ajax']);
        Route::post('/ajax', [LevelController::class, 'store_ajax']);
        Route::get('/{id}/edit_ajax', [LevelController::class, 'edit_ajax']);
        Route::put('/{id}/update_ajax', [LevelController::class, 'update_ajax']);
        Route::get('/{id}/delete_ajax', [LevelController::class, 'confirm_ajax']);
        Route::delete('/{id}/delete_ajax', [LevelController::class, 'delete_ajax']);
        Route::get('/show_ajax/{id}', [LevelController::class, 'showAjax']);
        Route::get('/import', [LevelController::class, 'import']);
        Route::post('/import_ajax', [LevelController::class, 'import_ajax']);
        Route::get('export_excel', [LevelController::class, 'export_excel']);
        Route::get('/export_pdf', [LevelController::class, 'export_pdf']);
    });

    // ADMIN AND MANAGER ROUTES
    // Inventory Management - Admin and Manager
    Route::prefix('barang')->middleware(['authorize:ADM,MNG'])->group(function () {
        Route::get('/', [BarangController::class, 'index']);
        Route::get('/list', [BarangController::class, 'list']);
        Route::get('/create', [BarangController::class, 'create']);
        Route::post('/', [BarangController::class, 'store']);
        Route::post('/store', [BarangController::class, 'store']);
        Route::get('/show/{id}', [BarangController::class, 'show']);
        Route::get('/edit/{id}', [BarangController::class, 'edit']);
        Route::put('/update/{id}', [BarangController::class, 'update']);
        Route::delete('/delete/{id}', [BarangController::class, 'delete']);
        Route::get('/show_ajax/{id}', [BarangController::class, 'showAjax']);
        Route::get('/create_ajax', [BarangController::class, 'create_ajax']);
        Route::post('/ajax', [BarangController::class, 'store_ajax']);
        Route::get('/{id}/edit_ajax', [BarangController::class, 'edit_ajax']);
        Route::put('/{id}/update_ajax', [BarangController::class, 'update_ajax']);
        Route::get('/{id}/delete_ajax', [BarangController::class, 'confirm_ajax']);
        Route::delete('/{id}/delete_ajax', [BarangController::class, 'delete_ajax']);
        Route::get('import', [BarangController::class, 'import']);
        Route::post('import_ajax', [BarangController::class, 'import_ajax']);
        Route::get('export_excel', [BarangController::class, 'export_excel']);
        Route::get('/export_pdf', [BarangController::class, 'export_pdf']);
    });

    Route::prefix('kategori')->middleware(['authorize:ADM,MNG'])->group(function () {
        Route::get('/', [KategoriController::class, 'index']);
        Route::get('/list', [KategoriController::class, 'list']);
        Route::get('/create', [KategoriController::class, 'create']);
        Route::post('/', [KategoriController::class, 'store']);
        Route::post('/store', [KategoriController::class, 'store']);
        Route::get('/show/{id}', [KategoriController::class, 'show']);
        Route::get('/edit/{id}', [KategoriController::class, 'edit']);
        Route::put('/update/{id}', [KategoriController::class, 'update']);
        Route::delete('/delete/{id}', [KategoriController::class, 'delete']);
        Route::get('/create_ajax', [KategoriController::class, 'create_ajax']);
        Route::post('/ajax', [KategoriController::class, 'store_ajax']);
        Route::get('/{id}/edit_ajax', [KategoriController::class, 'edit_ajax']);
        Route::put('/{id}/update_ajax', [KategoriController::class, 'update_ajax']);
        Route::get('/{id}/delete_ajax', [KategoriController::class, 'confirm_ajax']);
        Route::delete('/{id}/delete_ajax', [KategoriController::class, 'delete_ajax']);
        Route::get('/show_ajax/{id}', [KategoriController::class, 'showAjax']);
        Route::get('/import', [KategoriController::class, 'import']);
        Route::post('/import_ajax', [KategoriController::class, 'import_ajax']);
        Route::get('export_excel', [KategoriController::class, 'export_excel']);
        Route::get('/export_pdf', [KategoriController::class, 'export_pdf']);
    });

    Route::prefix('supplier')->middleware(['authorize:ADM,MNG'])->group(function () {
        Route::get('/', [SupplierController::class, 'index']);
        Route::get('/list', [SupplierController::class, 'list']);
        Route::get('/create', [SupplierController::class, 'create']);
        Route::post('/', [SupplierController::class, 'store']);
        Route::post('/store', [SupplierController::class, 'store']);
        Route::get('/show/{id}', [SupplierController::class, 'show']);
        Route::get('/edit/{id}', [SupplierController::class, 'edit']);
        Route::put('/update/{id}', [SupplierController::class, 'update']);
        Route::delete('/delete/{id}', [SupplierController::class, 'delete']);
        Route::get('/create_ajax', [SupplierController::class, 'create_ajax']);
        Route::post('/ajax', [SupplierController::class, 'store_ajax']);
        Route::get('/{id}/edit_ajax', [SupplierController::class, 'edit_ajax']);
        Route::put('/{id}/update_ajax', [SupplierController::class, 'update_ajax']);
        Route::get('/{id}/delete_ajax', [SupplierController::class, 'confirm_ajax']);
        Route::delete('/{id}/delete_ajax', [SupplierController::class, 'delete_ajax']);
        Route::get('/show_ajax/{id}', [SupplierController::class, 'showAjax']);
        Route::get('/import', [SupplierController::class, 'import']);
        Route::post('/import_ajax', [SupplierController::class, 'import_ajax']);
        Route::get('export_excel', [SupplierController::class, 'export_excel']);
        Route::get('/export_pdf', [SupplierController::class, 'export_pdf']);
    });


    Route::prefix('stok')->middleware(['authorize:ADM,MNG'])->group(function () {
        Route::get('/', [StockController::class, 'index']);
        Route::get('/list', [StockController::class, 'list']);
        Route::post('/', [StockController::class, 'store']);
        Route::get('/{id}', [StockController::class, 'show']);
        Route::get('/{id}/edit', [StockController::class, 'edit']);
        Route::put('/{id}', [StockController::class, 'update']);
        Route::delete('/{id}', [StockController::class, 'destroy']);
        Route::get('/export_excel', [StockController::class, 'export_excel']);
        Route::get('/export_pdf', [StockController::class, 'export_pdf']);
        Route::get('/show_allBarang', [StockController::class, 'showAllBarang']);
    });


    Route::prefix('penjualan')->middleware(['authorize:ADM,MNG,KAS'])->group(function () {
        Route::get('/', [PenjualanController::class, 'index']);
        Route::get('/list', [PenjualanController::class, 'list']);
        Route::get('/create', [PenjualanController::class, 'create']);
        Route::post('/', [PenjualanController::class, 'store']);
        Route::get('/{id}', [PenjualanController::class, 'show'])->where('id', '[0-9]+');
        Route::get('/{id}/pdf', [PenjualanController::class, 'generatePdf'])->where('id', '[0-9]+');
        Route::get('/export_excel', [PenjualanController::class, 'export_excel']);
        Route::get('/export_pdf', [PenjualanController::class, 'export_pdf']);
        Route::get('/barang/{id}', [PenjualanController::class, 'getBarangInfo'])->where('id', '[0-9]+');
    });

});
