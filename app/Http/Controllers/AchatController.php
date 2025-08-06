<?php

namespace App\Http\Controllers;

use App\Http\Requests\AchatRequest;
use App\Models\Achat;

class AchatController extends Controller
{
    public function addAchat(AchatRequest $request)
    {
        $achat = Achat::create($request->validated());

        return response()->json($achat, 201);
    }

    public function getAchats()
    {
        return response()->json(Achat::all());
    }

    public function getAchatById(Achat $achat)
    {
        return response()->json($achat);
    }

    public function updateAchat(AchatRequest $request, Achat $achat)
    {
        $achat->update($request->validated());

        return response()->json($achat);
    }

    public function deleteAchat(Achat $achat)
    {
        $achat->delete();

        return response()->json(null, 204);
    }
}