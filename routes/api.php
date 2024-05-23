<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


//M3
//search article api
Route::get('/articles', [ArticleController::class, 'search_api']);
//post article api
Route::post('/articles', [ArticleController::class, 'create_api']);
//delete article api
Route::delete('/articles/{id}', [ArticleController::class, 'delete_api']);


