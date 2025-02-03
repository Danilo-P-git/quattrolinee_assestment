<?php

use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\EventController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//routes events
Route::get('events/search', [EventController::class, 'search']);
Route::apiResource('events', EventController::class);

//routes categorie
Route::apiResource('categories', CategoryController::class);


//routes carrelli

Route::get('carts/{cart_id}', [CartController::class, 'show']);
