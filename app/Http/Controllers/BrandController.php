<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Car;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{
    /*
    *   Get all brands
    */
    public function getBrands(){
        $brands = Brand::all();
        return response()->json($brands);
    }

    /*
    *   Add a new brand
    */
    public function addBrand(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:brands|max:255',
            'origin' => 'required|string|max:255',
        ]);

        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 422);
        }
        

        $brand = new Brand();
        $brand->name = $request->name;
        $brand->origin = $request->origin;
        $brand->save();
        return response()->json($brand, 201);
    }

    /*
    *   Update a brand
    */
    public function updateBrand(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:brands|max:255',
            'origin' => 'required|string|max:255',
        ]);

        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $brand = Brand::find($id);
        if(!$brand){
            return response()->json(['message' => 'Brand not found'], 404);
        }
        $brand->name = $request->name;
        $brand->origin = $request->origin;
        $brand->save();
        return response()->json($brand, 200);
    }

    /*
    *   Delete a brand
    */
    public function deleteBrand($id){
        $brand = Brand::find($id);
        if(!$brand){
            return response()->json(['message' => 'Brand not found'], 404);
        }
        $brand->delete();
        return response()->json(['message' => 'Brand deleted successfully'], 200);
    }

    /*
    *  Returns Car list by the given brand
    */
    public function getCarsByBrand(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|exists:brands|max:255',
        ]);

        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $brand = Brand::where('name', $request->name)->first();
        $cars = $brand->cars;

        foreach($cars as $car){
            $car->categorie_id = $car->categorie->name;
            $car->brand_id = $car->brand->name;
        }

        return response()->json($cars, 200);
    }
}
