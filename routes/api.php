<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::get('/', function(){
    return response()->json(['message' => 'Welcome to the API CarCo!']);
});

Route::post('/car/create', [CarController::class, 'addCar']);
