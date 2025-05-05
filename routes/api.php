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
Route::get('/car', [CarController::class, 'getCars']);
Route::get('/car/{id}', [CarController::class, 'getCarById']);
Route::put('/car/{id}', [CarController::class, 'updateCar']);
Route::delete('/car/{id}', [CarController::class, 'deleteCar']);



Route::post('/categorie/create', [CategorieController::class, 'addCategorie']);
Route::get('/categorie', [CategorieController::class, 'getCategories']);
Route::get('/categorie/{id}', [CategorieController::class, 'getCategorieById']);
Route::put('/categorie/{id}', [CategorieController::class, 'updateCategorie']);
Route::delete('/categorie/{id}', [CategorieController::class, 'deleteCategorie']);



Route::post('/brand/create', [BrandController::class, 'addBrand']);
Route::get('/brand', [BrandController::class, 'getBrands']);
Route::get('/brand/{id}', [BrandController::class, 'getBrandById']);
Route::put('/brand/{id}', [BrandController::class, 'updateBrand']);
Route::delete('/brand/{id}', [BrandController::class, 'deleteBrand']);
