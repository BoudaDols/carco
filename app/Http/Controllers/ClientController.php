<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest;
use App\Models\Client;

class ClientController extends Controller
{
    public function addClient(ClientRequest $request)
    {
        $client = Client::create($request->validated());

        return response()->json($client, 201);
    }

    public function getClients()
    {
        return response()->json(Client::all());
    }

    public function getClientById(Client $client)
    {
        return response()->json($client);
    }

    public function updateClient(ClientRequest $request, Client $client)
    {
        $client->update($request->validated());

        return response()->json($client);
    }

    public function deleteClient(Client $client)
    {
        $client->delete();

        return response()->json(null, 204);
    }
}