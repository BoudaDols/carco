<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use App\Models\User;


class AuthController extends Controller
{
    // Inscription
    public function register(Request $request)
    {
        // $request->validate([
        //     'name'     => 'required|string|max:255',
        //     'email'    => 'required|email|unique:users',
        //     'password' => 'required|string|min:8',
        // ]);

        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|string|min:8',
        ]);

        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->active = $request->input('active', config('auth.default_user_active', env('DEFAULT_USER_ACTIVE', false)));
        $user->save();

        Log::channel('auth')->info('User registered', ['user_id' => $user->id, 'email' => $user->email]);

        return response()->json(['message' => 'Utilisateur créé avec succès.'], 201);
    }

    // Connexion
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validatedData = $validator->validated();
        $user = User::where('email', $validatedData['email'])->first();

        if (! $user || ! Hash::check($validatedData['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Identifiants incorrects.'],
            ]);
        }

        if (! $user->active) {
            throw ValidationException::withMessages([
                'email' => ['Compte désactivé.'],
            ]);
        }

        $token = $user->createToken(config('sanctum.token_name', env('SANCTUM_TOKEN_NAME', 'auth-token')))->plainTextToken;

        Log::channel('auth')->info('User logged in', ['user_id' => $user->id, 'email' => $user->email]);

        return response()->json([
            'access_token' => $token,
            'token_type'   => config('sanctum.token_type', env('SANCTUM_TOKEN_TYPE', 'Bearer')),
        ]);
    }

    // Déconnexion
    public function logout(Request $request)
    {
        $token = $request->user()->currentAccessToken();
        if ($token) {
            $token->delete();
        }

        Log::channel('auth')->info('User logged out', ['user_id' => $request->user()->id]);

        return response()->json(['message' => 'Déconnexion réussie.'], 200);
    }

    // Données utilisateur connecté
    public function me(Request $request)
    {
        $user = $request->user();
        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'active' => (bool) $user->active
        ], 200, [], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
}
