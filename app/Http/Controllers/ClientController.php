<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Client;

class ClientController extends Controller
{

    public function addClient(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'dateNaissance' => 'required|string|max:10',
            'sexe' => 'required|string|max:1',
            'domaineP' => 'required|string|max:25',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            Client::create($request->only(['name', 'dateNaissance', 'sexe', 'domaineP']));
            return response()->json(['message' => 'Client added successfully'], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create client'], 500);
        }
    }


    /*
    *   Get all clients
    *   @return Response
    */
    public function getClients(){
        $clients = Client::all();
        return response()->json($clients, 200);
    }


    /*
    *   Get a client by name
    *   @param Request $request
    *   @return Response
    */
    public function getClientByName(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|exists:clients,name'
        ]);

        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $client = Client::where('name', $request->input('name'))->get();

        return response()->json($client, 200);
    }


    public function updateClient(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|exists:clients,name',
            'dateNaissance' => 'required|string|max:10',
            'sexe' => 'required|string|max:1',
            'domaineP' => 'required|string|max:25',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $validatedData = $validator->validated();
            $client = Client::where('name', $validatedData['name'])->firstOrFail();
            $client->update([
                'dateNaissance' => $validatedData['dateNaissance'],
                'sexe' => $validatedData['sexe'],
                'domaineP' => $validatedData['domaineP']
            ]);
            return response()->json(['message' => 'Client updated successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update client'], 500);
        }
    }

    /*
    *   Delete a client by name
    *   @param Request $request
    *   @return Response
    */
    public function deleteClient(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|exists:clients,name'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $validatedData = $validator->validated();
            Client::where('name', $validatedData['name'])->firstOrFail()->delete();
            return response()->json(['message' => 'Client deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete client'], 500);
        }
    }
    
}
