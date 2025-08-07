<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\AchatController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CategorieController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/logout', [AuthController::class, 'logout']);

    });

    Route::prefix('cars')->group(function () {
        Route::post('/', [CarController::class, 'addCar']);
        Route::get('/', [CarController::class, 'getCars']);
        Route::get('/{car}', [CarController::class, 'getCarById']);
        Route::put('/{car}', [CarController::class, 'updateCar']);
        Route::delete('/{car}', [CarController::class, 'deleteCar']);
    });

    Route::prefix('categories')->group(function () {
        Route::post('/', [CategorieController::class, 'addCategorie']);
        Route::get('/', [CategorieController::class, 'getCategories']);
        Route::get('/{categorie}', [CategorieController::class, 'getCategorieById']);
        Route::put('/{categorie}', [CategorieController::class, 'updateCategorie']);
        Route::delete('/{categorie}', [CategorieController::class, 'deleteCategorie']);
        Route::get('/{categorie}/cars', [CategorieController::class, 'getCarsByCategorie']);
    });

    Route::prefix('brands')->group(function () {
        Route::post('/', [BrandController::class, 'addBrand']);
        Route::get('/', [BrandController::class, 'getBrands']);
        Route::get('/{brand}', [BrandController::class, 'getBrandById']);
        Route::put('/{brand}', [BrandController::class, 'updateBrand']);
        Route::delete('/{brand}', [BrandController::class, 'deleteBrand']);
        Route::get('/{brand}/cars', [BrandController::class, 'getCarsByBrand']);
    });

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
});



Route::get('/', function () {
    return response()->json(['message' => 'Welcome to the API CarCo!']);
});
