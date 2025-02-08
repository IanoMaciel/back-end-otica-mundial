<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;

class StockLensController extends Controller {

    public function getData(): JsonResponse {
        try {
            $apiUrl = env('APP_URL_API') . '/lens';
            $token = $this->login()->getData()->token;

            $response = Http::withToken($token)->get($apiUrl);

            if ($response->failed()) {
                return response()->json([
                    'error' => 'Erro ao buscar dados',
                    'message' => $response->json(),
                ], $response->status());
            }

            return response()->json($response->json());
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação.',
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function showData(int $id): JsonResponse {
        try {
            $apiUrl = env('APP_URL_API') . "/lens/{$id}";
            $token = $this->login()->getData()->token;

            $response = Http::withToken($token)->get($apiUrl);

            if ($response->failed()) {
                return response()->json([
                    'error' => 'Erro ao buscar dados',
                    'message' => $response->json(),
                ], $response->status());
            }

            return response()->json($response->json());
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação.',
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    private function login(): JsonResponse {
        try {
            $apiUrl = env('APP_URL_API') . '/login';

            $response = Http::post($apiUrl, [
                'email' => 'admin@admin.com',
                'password' => 'admin123'
            ]);

            if ($response->failed()) {
                return response()->json([
                    'error' => 'Error ao logar no sistema do laboratório.',
                ], $response->status());
            }

            $token = $response->json()['token'];

            return response()->json(['token' => $token]);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação.',
                'message' => $th->getMessage(),
            ], 500);
        }
    }
}
