<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Car;

class CarController extends Controller
{

    /*
    *   Add a new car
    *   @param Request $request
    *   @return Response
    */
    public function addCar(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'year' => 'required|integer|between:1900,' . date('Y'),
            'color'=> 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'chassisNumber'=> 'required|unique:cars|max:32',
            'description' => 'required|string|max:255',
            'categorie_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id'
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
        $car->categorie_id = $request->input('categorie_id');
        $car->brand_id = $request->input('brand_id');
        $car->save();
        return response()->json(['message' => 'Car added successfully'], 201);
    }


    /*
    *   Get a car by id
    *   @param Request $request
    *   @return Response
    */
    public function getCarById(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:cars,id'
        ]);

        $car = Car::find($request->input('id'));
    }


    /*
    *   Get all cars
    *   @return Response
    */
    public function getCars(){
        $cars = Car::all();
        foreach($cars as $car){
            $car->categorie_id = $car->categorie->name;
            $car->brand_id = $car->brand->name;
        }
        return response()->json($cars);
    }


    /*
    *   Update a car
    *   @param Request $request
    *   @return Response
    */
    public function updateCar(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:cars,id',
            'name' => 'required|string|max:255',
            'year' => 'required|integer|between:1900,' . date('Y'),
            'color'=> 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'chassisNumber'=> 'required|unique:cars|max:32',
            'description' => 'required|string|max:255',
            'categorie_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id'
        ]);

        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $car = Car::find($request->input('id'));
        $car->name = $request->input('name');
        $car->year = $request->input('year');
        $car->color = $request->input('color');
        $car->price = $request->input('price');
        $car->chassisNumber = $request->input('chassisNumber');
        $car->description = $request->input('description');
        $car->categorie_id = $request->input('categorie_id');
        $car->brand_id = $request->input('brand_id');
        $car->save();
        return response()->json(['message' => 'Car updated successfully'], 201);
    }


    /*
    *   Delete a car
    *   @param Request $request
    *   @return Response
    */
    public function deleteCar(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:cars,id'
        ]);

        $car = Car::find($request->input('id'));
        $car->delete();
        return response()->json(['message' => 'Car deleted successfully'], 201);
    }
}
