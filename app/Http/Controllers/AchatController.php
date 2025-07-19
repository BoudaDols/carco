<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AchatController extends Controller
{

    /*
    *
    *   Add a new achat
    *   @param Request $request
    *   @return Response
    *
    */
    public function addAchat(Request $request){
        $validator = Validator::make($request->all(), [
            'car_id' => 'required|exists:cars,id',
            'client_id' => 'required|exists:clients,id'
        ]);

        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $achat = new Achat();
        $achat->car_id = $request->input('car_id');
        $achat->client_id = $request->input('client_id');
        $achat->save();

        return response()->json(['message' => 'Achat created successfully'], 201);
    }



    /*
    *
    *   Get all achats
    *   @return Response
    *
    */
    public function getAchats(){
        $achats = Achat::all();
        return response()->json($achats);
    }


    /*
    *
    *   Get achat by id
    *   @param Request $request
    *   @return Response
    *
    */
    public function getAchatById(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:achats,id'
        ]);

        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $achat = Achat::find($request->input('id'));
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

        $achats = Achat::where('client_id', $request->input('client_id'))->get();
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

        $achats = Achat::where('car_id', $request->input('car_id'))->get();
        return response()->json($achats);
    }
}
