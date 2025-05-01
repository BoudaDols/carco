<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\BrandController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::get('/', function(){
    return response()->json(['message' => 'Welcome to the API CarCo!']);
});

Route::post('/car/create', [CarController::class, 'addCar']);



Route::post('/categorie/create', [CategorieController::class, 'addCategorie']);



Route::post('/brand/create', [BrandController::class, 'addBrand']);
