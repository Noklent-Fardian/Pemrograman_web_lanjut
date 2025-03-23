<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\BarangController;


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

Route::get('/welcome', [WelcomeController::class, 'index']);