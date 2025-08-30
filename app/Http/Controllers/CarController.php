<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Car;

class CarController extends Controller
{
    private const CAR_FIELDS = [
        'name', 'year', 'color', 'price', 
        'chassisNumber', 'description', 
        'categorie_id', 'brand_id'
    ];

    private function getCarValidationRules($carId = null): array
    {
        $uniqueRule = $carId ? "unique:cars,chassisNumber,{$carId}" : 'unique:cars';
        
        return [
            'name' => 'required|string|max:255',
            'year' => 'required|integer|between:1900,' . date('Y'),
            'color' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'chassisNumber' => "required|{$uniqueRule}|max:32",
            'description' => 'required|string|max:255',
            'categorie_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id'
        ];
    }

    public function addCar(Request $request)
    {
        $validator = Validator::make($request->all(), $this->getCarValidationRules());

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            Car::create($request->only(self::CAR_FIELDS));
            return response()->json(['message' => 'Car added successfully'], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create car'], 500);
        }
    }

    
    public function getCarById($id)
    {
        $car = Car::with(['categorie', 'brand'])->findOrFail($id);
        
        return response()->json([
            'id' => $car->id,
            'name' => $car->name,
            'year' => $car->year,
            'color' => $car->color,
            'price' => $car->price,
            'chassisNumber' => $car->chassisNumber,
            'description' => $car->description,
            'category' => $car->categorie->name,
            'brand' => $car->brand->name
        ], 200);
    }


    public function getCars()
    {
        $cars = Car::with(['categorie', 'brand'])->get();
        
        return response()->json($cars->map(function ($car) {
            return [
                'id' => $car->id,
                'name' => $car->name,
                'year' => $car->year,
                'color' => $car->color,
                'price' => $car->price,
                'chassisNumber' => $car->chassisNumber,
                'description' => $car->description,
                'category' => $car->categorie->name,
                'brand' => $car->brand->name
            ];
        }), 200);
    }


    public function updateCar(Request $request)
    {
        $carId = $request->input('id');
        $rules = array_merge(['id' => 'required|exists:cars,id'], $this->getCarValidationRules($carId));
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $car = Car::findOrFail($request->input('id'));
            $car->update($request->only(self::CAR_FIELDS));
            return response()->json(['message' => 'Car updated successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update car'], 500);
        }
    }


    public function deleteCar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:cars,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            Car::findOrFail($request->input('id'))->delete();
            return response()->json(['message' => 'Car deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete car'], 500);
        }
    }

    public function getCarByName(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validatedData = $validator->validated();
        $cars = Car::with(['categorie', 'brand'])
            ->where('name', 'like', '%' . $validatedData['name'] . '%')
            ->get();

        return response()->json($cars->map(function ($car) {
            return [
                'id' => $car->id,
                'name' => $car->name,
                'category' => $car->categorie->name,
                'brand' => $car->brand->name
            ];
        }), 200);
    }
}
