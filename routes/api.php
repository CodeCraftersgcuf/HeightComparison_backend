<?php

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\ContactController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('entities', [ApiController::class,'entities']);
Route::get('ectomorph', [ApiController::class,'avatar_ectomorph']);
Route::get('endomorph', [ApiController::class,'avatar_endomorph']);
Route::get('mesomorph', [ApiController::class,'avatar_mesomorph']);

// to use this route use query keyword for example:
// http://127.0.0.1:8000/api/search?query=john
// search api route
Route::get('/search', [ApiController::class, 'search']);

// Categories
Route::get('/categories',[ApiController::class,'categories']);
// subcategories route
Route::get('/categories/{id}/subcategories',[ApiController::class,'subcategories']);
// fictionalSubcategory route
Route::get('/subcategories/{id}/fictionalSubcategory',[ApiController::class,'fictionalSubcategory']);
// celebrity_data route
Route::get('/subcategories/{id}/celebrity_data',[ApiController::class,'celebrity_data']);
// fictional_data route
Route::get('/fictionalSubcategory/{id}/fictional_data',[ApiController::class,'fictional_data']);