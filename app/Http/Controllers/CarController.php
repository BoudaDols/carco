<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Car;

class CarController extends Controller
{
    public function addCar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'year' => 'required|integer|between:1900,' . date('Y'),
            'color'=> 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'chassisNumber'=> 'required|string|max:32',
            'description' => 'required|string|max:255',
        ]);


        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 422);
        }
        
        $car = new Car();
        $car->name = $request->input('name');
        $car->year = $request->input('year');
        $car->color = $request->input('color');
        $car->price = $request->input('price');
        $car->chassisNumber = $request->input('chassisNumber');
        $car->description = $request->input('description');
        $car->save();
        return response()->json(['message' => 'Car added successfully'], 201);
    }
}
