<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if ( !$token = auth()->attempt( $credentials ) )
            return response()->json(['message' => 'Unos de los datos son incorrectos'], 401);
        else{
            return response()->json([
                'token' => $token,
                'user' => auth()->user(),
                'type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60
            ],200);
        }
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Logged Out'],200);
    }

    public function refresh()
    {
        $token = auth()->refresh();

        return response()->json([
            'token' => $token,
            'user' => auth()->user(),
            'type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ],200);
    }
}
