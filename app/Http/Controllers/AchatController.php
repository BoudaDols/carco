<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Achat;

class AchatController extends Controller{

    public function addAchat(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'car_id' => 'required|exists:cars,id',
            'client_id' => 'required|exists:clients,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            Achat::create($request->only(['car_id', 'client_id']));
            return response()->json(['message' => 'Achat created successfully'], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create achat'], 500);
        }
    }



    public function getAchats(Request $request)
    {
        $perPage = min($request->input('per_page', 15), 50);
        return response()->json(Achat::paginate($perPage));
    }

    public function getAchatById(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:achats,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->toArray()], 422);
        }

        $achat = Achat::findOrFail($request->input('id'));
        return response()->json($achat);
    }


    /*
    *
    *   Get achat by client
    *   @param Request $request
    *   @return Response
    *
    */
    public function getAchatByClient(Request $request){
        $validator = Validator::make($request->all(), [
            'client_id' => 'required|exists:clients,id'
        ]);

        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validatedData = $validator->validated();
        $achats = Achat::where('client_id', $validatedData['client_id'])->get();
        return response()->json($achats);
    }



    /*
    *
    *   Get achat by car
    *   @param Request $request
    *   @return Response
    *
    */
    public function getAchatByCar(Request $request){
        $validator = Validator::make($request->all(), [
            'car_id' => 'required|exists:cars,id'
        ]);

        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validatedData = $validator->validated();
        $achats = Achat::where('car_id', $validatedData['car_id'])->get();
        return response()->json($achats);
    }


    public function updateAchat(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:achats,id',
            'car_id' => 'required|exists:cars,id',
            'client_id' => 'required|exists:clients,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $validatedData = $validator->validated();
            $achat = Achat::findOrFail($validatedData['id']);
            $achat->update([
                'car_id' => $validatedData['car_id'],
                'client_id' => $validatedData['client_id']
            ]);
            return response()->json(['message' => 'Achat updated successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update achat'], 500);
        }
    }

    public function deleteAchat(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:achats,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $validatedData = $validator->validated();
            Achat::findOrFail($validatedData['id'])->delete();
            return response()->json(['message' => 'Achat deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete achat'], 500);
        }
    }
    
}