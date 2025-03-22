<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/level', [LevelController::class, 'index']);
Route::get('/kategori', [KategoriController::class, 'index']);


Route::prefix('user')->group(function () {
    Route::get('/', [UserController::class, 'index']);
    Route::get('/tambah', [UserController::class, 'tambah']);
    Route::post('/tambah_simpan', [UserController::class, 'tambah_simpan']);
    Route::get('/ubah/{id}', [UserController::class, 'edit']);
    Route::put('/ubah_simpan/{id}', [UserController::class, 'ubah_simpan']);
    Route::get('/hapus/{id}', [UserController::class, 'hapus']);
});

Route::get('/welcome', [WelcomeController::class, 'index']);