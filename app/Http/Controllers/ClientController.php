<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClientController extends Controller
{

    /*
    *   Add a client
    *   @param Request $request
    *   @return Response
    */
    public function addClient(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'dateNaissance' => 'required|string|max:10',
            'sexe' => 'required|string|max:1',
            'domaineP' => 'required|string|max:25',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $client = new Client();
        $client->name = $request->input('name');
        $client->dateNaissance = $request->input('dateNaissance');
        $client->sexe = $request->input('sexe');
        $client->domaineP = $request->input('domaineP');
        $client->save();

        return response()->json(['message' => 'Client added successfully'], 200);
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



    /*
    *   Update a client
    *   @param Request $request
    *   @return Response
    */
    public function updateClient(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|exists:clients,name',
            'dateNaissance' => 'required|string|max:10',
            'sexe' => 'required|string|max:1',
            'domaineP' => 'required|string|max:25',
        ]);

        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $client = Client::where('name', $request->input('name'))->first();

        $client->dateNaissance = $request->input('dateNaissance');
        $client->sexe = $request->input('sexe');
        $client->domaineP = $request->input('domaineP');
        $client->save();

        return response()->json(['message' => 'Client updated successfully'], 200);
    }



    /*
    *   Delete a client
    *   @param Request $request
    *   @return Response
    */
    public function deleteClient(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|exists:clients,name'
        ]);

        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $client = Client::where('name', $request->input('name'))->first();
        $client->delete();

        return response()->json(['message' => 'Client deleted successfully'], 200);
    }
    
}
