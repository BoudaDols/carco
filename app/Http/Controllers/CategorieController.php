<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategorieRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Categorie;

class CategorieController extends Controller
{
    public function addCategorie(CategorieRequest $request)
    {
        $categorie = Categorie::create($request->validated());

        return response()->json($categorie, 201);
    }

    public function getCategories()
    {
        return response()->json(Categorie::all());
    }

    public function getCategorieById(Categorie $categorie)
    {
        return response()->json($categorie);
    }

    public function updateCategorie(CategorieRequest $request, Categorie $categorie)
    {
        $categorie->update($request->validated());

        return response()->json($categorie);
    }

    public function deleteCategorie(Categorie $categorie)
    {
        $categorie->delete();

        return response()->json(null, 204);
    }

    public function getCarsByCategorie(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|exists:categories|max:255',
        ]);

        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $categorie = Categorie::where('name', $request->name)->first();
        $cars = $categorie->cars;

        foreach($cars as $car){
            $car->categorie_id = $car->categorie->name;
            $car->brand_id = $car->brand->name;
        }

        return response()->json($cars, 200);
    }
}
