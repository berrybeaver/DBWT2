<?php

use Illuminate\Support\Facades\Route;

Route::get('/login', [App\Http\Controllers\AuthController::class, 'login'])->name('login');
Route::get('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
Route::get('/isloggedin', [App\Http\Controllers\AuthController::class, 'isloggedIn'])->name('haslogin');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [\App\Http\Controllers\NavigationController::class, 'showMenu']);
Route::get('/newarticle/', function (){
    return view('articles.addnew');
});
Route::get('/articles/', [App\Http\Controllers\ArticleController::class, 'index']);
Route::get('/articles/{search}', [App\Http\Controllers\ArticleController::class, 'index'])->name('articles.search');
Route::post('/articles/', [\App\Http\Controllers\ArticleController::class, 'store']);

