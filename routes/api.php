<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ShoppingcartController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


//search article api
Route::get('/articles', [ArticleController::class, 'search_api']);
//post article api
Route::post('/articles', [ArticleController::class, 'create_api']);


//add item to shopping cart
Route::post('/shoppingcart', [ShoppingcartController::class, 'store']);
Route::get('/shoppingcart', [ShoppingcartController::class, 'init']);
Route::delete('/shoppingcart/{shoppingcartid}/articles/{articleId}', [ShoppingCartController::class, 'removeItem']);
