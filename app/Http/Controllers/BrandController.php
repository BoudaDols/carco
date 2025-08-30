<?php

namespace App\Http\Controllers;

use App\Http\Requests\BrandRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Brand;

class BrandController extends Controller
{
    public function addBrand(BrandRequest $request)
    {
        $brand = Brand::create($request->validated());

        return response()->json($brand, 201);
    }

    public function getBrands()
    {
        return response()->json(Brand::all());
    }

    public function getBrandById(Brand $brand)
    {
        return response()->json($brand);
    }

    public function updateBrand(BrandRequest $request, Brand $brand)
    {
        $brand->update($request->validated());

        return response()->json($brand);
    }

    public function deleteBrand(Brand $brand)
    {
        $brand->delete();

        return response()->json(null, 200);
    }

    public function getCarsByBrand(Request $request)
    {
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
