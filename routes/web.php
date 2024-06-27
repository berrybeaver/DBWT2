<?php

use App\Events\Wartungsevent;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

//authentication
Route::get('/login', [App\Http\Controllers\AuthController::class, 'login'])->name('login');
Route::get('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
Route::get('/isloggedin', [App\Http\Controllers\AuthController::class, 'isloggedIn'])->name('haslogin');

//
Route::get('/home', [\App\Http\Controllers\NavigationController::class, 'showMenu']);

//add new article
Route::get('/newarticle/', function (){
    return view('articles.addnew');
});
//show articles
Route::get('/articles/', [App\Http\Controllers\ArticleController::class, 'index']);

//add shopping cart
Route::get('/articles/newShoppingCart', [App\Http\Controllers\ShoppingcartController::class, 'index']);

//newsite
Route::get('/newsite', function(){
    return view('newsite');
});

Route::get('/newsite/maintenance', function (){
    event(new Wartungsevent());
});
