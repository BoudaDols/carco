<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Categorie;

class CategorieController extends Controller
{
    /*
    * Add a new categorie
    */
    public function addCategorie(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:categories|max:255',
        ]);

        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 422);
        }


        $categorie = new Categorie();
        $categorie->name = $request->input('name');
        $categorie->save();
        return response()->json($categorie, 201);
    }

    /*
    * Get all categories
    */
    public function getCategories(){
        $categories = Categorie::all();
        return response()->json($categories, 200);
    }

    /*
    * Get a categorie by id
    */
    public function getCategorieById($id){
        $categorie = Categorie::find($id);
        if($categorie){
            return response()->json($categorie, 200);
        }else{
            return response()->json(['message' => 'Categorie not found'], 404);
        }
    }

    /*
    * Update a categorie
    */
    public function updateCategorie(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:categories|max:255',
        ]);

        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $categorie = Categorie::find($id);
        if($categorie){
            $categorie->name = $request->input('name');
            $categorie->save();
            return response()->json($categorie, 200);
        }else{
            return response()->json(['message' => 'Categorie not found'], 404);
        }
    }

    /*
    * Delete a categorie
    */
    public function deleteCategorie($id){
        $categorie = Categorie::find($id);
        if($categorie){
            $categorie->delete();
            return response()->json(['message' => 'Categorie deleted'], 200);
        }else{
            return response()->json(['message' => 'Categorie not found'], 404);
        }
    }
}
