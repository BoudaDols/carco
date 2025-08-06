<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategorieRequest;
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

    public function getCarsByCategorie(Categorie $categorie)
    {
        $cars = $categorie->cars()->with(['brand', 'category'])->get();

        return response()->json($cars);
    }
}