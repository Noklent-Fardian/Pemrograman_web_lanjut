<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\SupplierController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [WelcomeController::class, 'index']);

Route::get('/level', [LevelController::class, 'index']);
Route::get('/kategori', [KategoriController::class, 'index']);


Route::prefix('user')->group(function () {
    Route::get('/', [UserController::class, 'index']);
    Route::get('/list', [UserController::class, 'list']);
    Route::get('/create', [UserController::class, 'create']);
    Route::post('/', [UserController::class,'store']); // Add this line to handle POST to /user
    Route::post('/store', [UserController::class,'store']); // Keep this for backward compatibility
    Route::get('/show/{id}', [UserController::class,'show']);
    Route::get('/edit/{id}', [UserController::class,'edit']);
    Route::put('/update/{id}', [UserController::class,'update']);
    Route::delete('/delete/{id}', [UserController::class,'delete']); 

});
Route::prefix('barang')->group(function () {
    Route::get('/', [BarangController::class, 'index']);
    Route::get('/list', [BarangController::class, 'list']);
    Route::get('/create', [BarangController::class, 'create']);
    Route::post('/', [BarangController::class, 'store']);
    Route::post('/store', [BarangController::class,'store']); //
    Route::get('/show/{id}', [BarangController::class, 'show']);
    Route::get('/edit/{id}', [BarangController::class, 'edit']);
    Route::put('/update/{id}', [BarangController::class, 'update']);
    Route::delete('/delete/{id}', [BarangController::class, 'delete']);
});
Route::prefix('level')->group(function () {
    
    Route::get('/', [LevelController::class, 'index']);
    Route::get('/list', [LevelController::class, 'list']);
    Route::get('/create', [LevelController::class, 'create']);
    Route::post('/', [LevelController::class, 'store']);
    Route::post('/store', [LevelController::class,'store']); //
    Route::get('/show/{id}', [LevelController::class,'show']);
    Route::get('/edit/{id}', [LevelController::class,'edit']);
    Route::put('/update/{id}', [LevelController::class,'update']);
    Route::delete('/delete/{id}', [LevelController::class,'delete']);

});
Route::prefix('kategori')->group(function () {
    Route::get('/', [KategoriController::class, 'index']);
    Route::get('/list', [KategoriController::class, 'list']);
    Route::get('/create', [KategoriController::class, 'create']);
    Route::post('/', [KategoriController::class, 'store']);
    Route::post('/store', [KategoriController::class,'store']);
    Route::get('/show/{id}', [KategoriController::class,'show']);
    Route::get('/edit/{id}', [KategoriController::class,'edit']);
    Route::put('/update/{id}', [KategoriController::class,'update']);
    Route::delete('/delete/{id}', [KategoriController::class,'delete']);
});

Route::prefix('supplier')->group(function () {
    Route::get('/', [SupplierController::class, 'index']);
    Route::get('/list', [SupplierController::class, 'list']);
    Route::get('/create', [SupplierController::class, 'create']);
    Route::post('/', [SupplierController::class, 'store']);
    Route::post('/store', [SupplierController::class,'store']);
    Route::get('/show/{id}', [SupplierController::class,'show']);
    Route::get('/edit/{id}', [SupplierController::class,'edit']);
    Route::put('/update/{id}', [SupplierController::class,'update']);
    Route::delete('/delete/{id}', [SupplierController::class,'delete']);
});
Route::get('/welcome', [WelcomeController::class, 'index']);