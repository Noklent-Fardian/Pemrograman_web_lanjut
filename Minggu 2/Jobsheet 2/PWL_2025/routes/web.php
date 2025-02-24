<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\ArticleContoller;
use App\Http\Controllers\AboutContoller;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;

// Route::get('/', [PageController::class, 'index']);
// Route::get('/about', [PageController::class, 'about']);
// Route::get('/articles/{id}', [PageController::class, 'articles']);

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

Route::get('/', [HomeController::class,'index']);

Route::get('/about', [AboutContoller::class,'about']);

Route::get('/articles/{id}', [ArticleContoller::class,'articles']);

Route::get('/helllo', [WelcomeController::class,'hello']);

Route::get('/world', function () {
    return 'World';
});

// Route::get('/user/{name}', function ($name) {
//     return 'Nama saya ' . $name;
// });

Route::get('/posts/{post}/comments/{comment}', function ($postId, $commentId) {
    return 'Pos ke-' . $postId . " Komentar ke-: " . $commentId;
});


Route::get('/user/{name?}', function ($name = 'John') {
    return 'Nama saya ' . $name;
});


// // Name route
// Route::get('/user/profile', function () {
//     // 
// })->name('profile');
// Route::get(
//     '/user/profile',
//     // [UserProfileController::class, 'show']
// )->name('profile');
// // Generating URLs... 
// $url = route('profile');
// // Generating Redirects... 
// return redirect()->route('profile');


