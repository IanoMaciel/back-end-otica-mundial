<?php

namespace App\Http\Controllers;

use App\Models\SaleItem;
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

        return response()->json(['token' => $token])->withCookie($cookie);
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

    public function auth(Request $request): JsonResponse {
        $validatedData = $request->validate(
            [
                'email' => 'required|email|exists:users,email',
                'password' => 'required',
                ''
            ],
            [
                'email.required' => 'O campo e-mail é obrigatório.',
                'email.email' => 'O e-mail fornecido não é um endereço de e-mail válido.',
                'email.exists' => 'O e-mail ou senha informada não existe na base de dados.',

                'password.required' => 'O campo senha é obrigatório.'
            ]
        );

        if(!Auth::attempt($validatedData)) {
            return response()->json([
                'error' => 'Credenciais inválidas!'
            ], 401);
        }

        $user = Auth::user();

        if (!$user->is_admin && !$user->is_manager) {
            return response()->json([
                'error' => 'Ops! Somente usuários de nível gerente ou administrador podem aplicar descontos.',
            ], 422);
        }

        try {
            return response()->json([
                'message' => 'Desconto aplicado com sucesso!',
                'user' => $user,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação.',
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
