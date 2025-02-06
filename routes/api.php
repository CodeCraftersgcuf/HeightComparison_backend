<?php

use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('entities', [ApiController::class,'entities']);
Route::get('ectomorph', [ApiController::class,'avatar_ectomorph']);
Route::get('endomorph', [ApiController::class,'avatar_endomorph']);
Route::get('mesomorph', [ApiController::class,'avatar_mesomorph']);

Route::get('/categories',[ApiController::class,'categories']);
Route::get('/categories/{id}/subcategories',[ApiController::class,'subcategories']);
Route::get('/subcategories/{id}/fictionalSubcategory',[ApiController::class,'fictionalSubcategory']);
Route::get('/subcategories/{id}/celebrity_data',[ApiController::class,'celebrity_data']);
Route::get('/fictionalSubcategory/{id}/fictional_data',[ApiController::class,'fictional_data']);