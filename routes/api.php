<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\CategorieController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/logout', [AuthController::class, 'logout']);

    });
});

Route::post('/car', [CarController::class, 'addCar']);
Route::get('/cars', [CarController::class, 'getCars']);
Route::get('/car/{car}', [CarController::class, 'getCarById']);
Route::put('/car/{car}', [CarController::class, 'updateCar']);
Route::delete('/car/{car}', [CarController::class, 'deleteCar']);
Route::get('/cars/search', [CarController::class, 'getCarByName']);

Route::post('/categorie/create', [CategorieController::class, 'addCategorie']);
Route::get('/categories', [CategorieController::class, 'getCategories']);
Route::get('/categorie/{id}', [CategorieController::class, 'getCategorieById']);
Route::put('/categorie/{id}', [CategorieController::class, 'updateCategorie']);
Route::delete('/categorie/{id}', [CategorieController::class, 'deleteCategorie']);
Route::get('/categories/cars', [CategorieController::class, 'getCarsByCategorie']);

Route::post('/brand/create', [BrandController::class, 'addBrand']);
Route::get('/brands', [BrandController::class, 'getBrands']);
Route::get('/brand/{id}', [BrandController::class, 'getBrandById']);
Route::put('/brand/{id}', [BrandController::class, 'updateBrand']);
Route::delete('/brand/{id}', [BrandController::class, 'deleteBrand']);
Route::get('/brands/cars', [BrandController::class, 'getCarsByBrand']);

Route::post('/achat', [AchatController::class, 'addAchat']);
Route::get('/achats', [AchatController::class, 'getAchats']);
Route::get('/achat/{achat}', [AchatController::class, 'getAchatById']);
Route::put('/achat/{achat}', [AchatController::class, 'updateAchat']);
Route::delete('/achat/{achat}', [AchatController::class, 'deleteAchat']);

Route::post('/client', [ClientController::class, 'addClient']);
Route::get('/clients', [ClientController::class, 'getClients']);
Route::get('/client/{client}', [ClientController::class, 'getClientById']);
Route::put('/client/{client}', [ClientController::class, 'updateClient']);
Route::delete('/client/{client}', [ClientController::class, 'deleteClient']);

Route::get('/', function () {
    return response()->json(['message' => 'Welcome to the API CarCo!']);
});
