<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{
    public function addBrand(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:brands|max:255',
            'origin' => 'required|string|max:255',
        ]);

        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 422);
        }
        if(Brand::where('name', $request->name)->exists()){
            return response()->json(['errors' => 'Brand already exists'], 422);
        }

        $brand = new Brand();
        $brand->name = $request->name;
        $brand->origin = $request->origin;
        $brand->save();
        return response()->json($brand, 201);
    }
}
