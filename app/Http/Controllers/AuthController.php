<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller {
    public function login(Request $request): JsonResponse {
        if(!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'error' => 'Credenciais inválidas!'
            ], 401);
        }

        $user = Auth::user();
        $token = $user->createToken('token')->plainTextToken;
        $cookie = cookie('jwt', $token, 60 * 24);

        return response()->json(['message' => 'Sucesso!'])->withCookie($cookie);
    }

    public function logout(Request $request): JsonResponse{
        $user = Auth::user();
        $user->tokens()->delete();
        $cookie = cookie('jwt', '', -1);
        return response()->json(['message' => 'Logout realizado com sucesso!'])->withCookie($cookie);
    }

    public function me(): JsonResponse {
        $user = Auth::user();
        return response()->json($user);
    }
}
