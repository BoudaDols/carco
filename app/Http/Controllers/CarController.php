<?php

namespace App\Http\Controllers;

use App\Http\Requests\CarRequest;
use App\Models\Car;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function addCar(CarRequest $request)
    {
        $car = Car::create($request->validated());

        return response()->json($car, 201);
    }

    public function getCars(Request $request)
    {
        $query = Car::query();

        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }

        return response()->json($query->get());
    }

    public function getCarById(Car $car)
    {
        return response()->json($car);
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
