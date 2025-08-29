<?php

namespace App\Http\Controllers;

use App\Http\Requests\BrandRequest;
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

    public function getCarsByBrand(Brand $brand)
    {
        $cars = $brand->cars()->with(['brand', 'category'])->get();

        return response()->json($cars);
    }
}
