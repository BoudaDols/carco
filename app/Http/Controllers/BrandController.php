<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Car;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class BrandController extends Controller
{
    /*
    *   Get all brands
    */
    public function getBrands(){
        $brands = Brand::all();
        return response()->json($brands, 200);
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
        Log::channel('api')->info('Brand created', ['brand_id' => $brand->id, 'name' => $brand->name]);
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
        Log::channel('api')->info('Brand updated', ['brand_id' => $brand->id, 'name' => $brand->name]);
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
        $brandName = $brand->name;
        $brand->delete();
        Log::channel('api')->info('Brand deleted', ['brand_id' => $id, 'name' => $brandName]);
        return response()->json(['message' => 'Brand deleted successfully'], 200);
    }

    public function getCarsByBrand(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|exists:brands|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $brand = Brand::where('name', $request->name)->firstOrFail();
        $cars = $brand->cars()->with('categorie')->get();

        return response()->json($cars->map(function ($car) use ($brand) {
            return [
                'id' => $car->id,
                'name' => $car->name,
                'category' => $car->categorie->name,
                'brand' => $brand->name
            ];
        }), 200);
    }
}
