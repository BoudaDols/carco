<?php

namespace App\Http\Controllers;

use App\Http\Requests\CarRequest;
use Illuminate\Support\Facades\Validator;
use App\Models\Car;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function addCar(CarRequest $request)
    {
        $car = Car::create($request->validated());

        return response()->json($car, 201);
    }

    public function getCars()
    {
        $cars = Car::all();
        foreach($cars as $car){
            $car->categorie_id = $car->categorie->name;
            $car->brand_id = $car->brand->name;
        }
        return response()->json($cars, 200);
    }

    public function getCarById(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:cars,id'
        ]);
        
        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $car = Car::find($request->input('id'));
        $car->categorie_id = $car->categorie->name;
        $car->brand_id = $car->brand->name;

        return response()->json($car, 200);
    }

    public function updateCar(CarRequest $request, Car $car)
    {
        $car->update($request->validated());

        return response()->json($car);
    }

    public function deleteCar(Car $car)
    {
        $car->delete();

        return response()->json(null, 204);
    }
}