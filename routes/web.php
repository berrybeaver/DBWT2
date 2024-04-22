<?php

use Illuminate\Support\Facades\Route;

Route::get('/login', [App\Http\Controllers\AuthController::class, 'login'])->name('login');
Route::get('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
Route::get('/isloggedin', [App\Http\Controllers\AuthController::class, 'isloggedin'])->name('haslogin');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/articles/', [App\Http\Controllers\ArticleController::class, 'index']);
Route::get('/articles/{search}', [App\Http\Controllers\ArticleController::class, 'index'])->name('articles.search');

