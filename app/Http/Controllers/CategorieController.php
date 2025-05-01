<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Categorie;

class CategorieController extends Controller
{
    public function addCategorie(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:categories|max:255',
        ]);

        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 422);
        }
        // if(Categorie::where('name', $request->input('name'))->exists()){
        //     return response()->json(['errors' => 'Categorie already exists'], 422);
        // }


        $categorie = new Categorie();
        $categorie->name = $request->input('name');
        $categorie->save();
        return response()->json($categorie, 201);
    }
}
