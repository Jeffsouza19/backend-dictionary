<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DictionaryController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/**
 * Fullstack Challenge 🏅 - Dictionary
 *
 * @group Welcome
 * @response {"message": "Fullstack Challenge 🏅 - Dictionary"}
 */
Route::get('/', function (Request $request) {
    return response()->json(["message" => "Fullstack Challenge 🏅 - Dictionary"]);
});

Route::group(['prefix' => 'auth'], function () {
    Route::post('signin', [AuthController::class, 'signin']);
    Route::post('signup', [AuthController::class, 'signup']);
});

Route::group([
    'middleware' => 'auth:sanctum',
    'prefix' => 'entries/en'
], function () {
    Route::get('/', [DictionaryController::class, 'list']);
    Route::get('/{word}', [DictionaryController::class, 'view']);
    Route::post('/{word}/favorite', [DictionaryController::class, 'favorite']);
    Route::delete('/{word}/unfavorite', [DictionaryController::class, 'unfavorite']);
});

Route::group([
    'middleware' => 'auth:sanctum',
    'prefix' => 'user/me'
], function (){
    Route::get('/', [UserController::class, 'me']);
    Route::get('/history', [UserController::class, 'history']);
    Route::get('/favorites', [UserController::class, 'favorites']);
});

Route::get('/401', function (){
   return response()->json(["message" => "Unauthorized"], 401);
});
