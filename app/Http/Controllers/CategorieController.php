<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Models\Categorie;
use App\Models\Car;

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
        Log::channel('api')->info('Category created', ['category_id' => $categorie->id, 'name' => $categorie->name]);
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
            Log::channel('api')->info('Category updated', ['category_id' => $categorie->id, 'name' => $categorie->name]);
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
            $categorieName = $categorie->name;
            $categorie->delete();
            Log::channel('api')->info('Category deleted', ['category_id' => $id, 'name' => $categorieName]);
            return response()->json(['message' => 'Categorie deleted'], 200);
        }else{
            return response()->json(['message' => 'Categorie not found'], 404);
        }
    }

    public function getCarsByCategorie(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|exists:categories|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validatedData = $validator->validated();
        $categorie = Categorie::where('name', $validatedData['name'])->firstOrFail();
        $cars = $categorie->cars()->with('brand')->get();

        return response()->json($cars->map(function ($car) use ($categorie) {
            return [
                'id' => $car->id,
                'name' => $car->name,
                'category' => $categorie->name,
                'brand' => $car->brand->name
            ];
        }), 200);
    }
}
