<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller {
    protected $paymentMethod;
    public function __construct(PaymentMethod $paymentMethod) {
        $this->paymentMethod = $paymentMethod;
    }

    public function index(): JsonResponse {
        return response()->json($this->paymentMethod->query()->orderBy('payment_method')->get());
    }

    public function store(Request $request): JsonResponse {
        $validatedData = $request->validate(
            $this->paymentMethod->rules(),
            $this->paymentMethod->messages()
        );

        try {
            $paymentMethod = $this->paymentMethod->query()->create($validatedData);
            return response()->json($paymentMethod, 201);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação.',
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function show(int $id): JsonResponse {
        $paymentMethod = $this->paymentMethod->query()->find($id);
        if (!$paymentMethod) {
            return response()->json([
                'error' => 'O Método de Pagamento iformado não existe na base de dados.'
            ], 404);
        }
        return response()->json($paymentMethod);
    }

    public function update(Request $request, int $id): JsonResponse {
        $paymentMethod = $this->paymentMethod->query()->find($id);
        if (!$paymentMethod) {
            return response()->json([
                'error' => 'O Método de Pagamento iformado não existe na base de dados.'
            ], 404);
        }

        $validatedData = $request->validate(
            $this->paymentMethod->rules(true),
            $this->paymentMethod->messages()
        );

        $paymentMethodExists = $this->paymentMethod->query()
            ->where('payment_method', $validatedData['payment_method'])
            ->where('id', '<>', $id)
            ->exists();

        if ($paymentMethodExists) {
            return response()->json([
                'error' => 'O Método de Pagamento informado já existe na base de dados.'
            ], 404);
        }

        try {
            $paymentMethod->update($validatedData);
            return response()->json($paymentMethod);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação.',
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function destroy(int $id): JsonResponse {
        $paymentMethod = $this->paymentMethod->query()->find($id);
        if (!$paymentMethod) {
            return response()->json([
                'error' => 'O Método de Pagamento informado não existe na base de dados.'
            ], 404);
        }

        try {
            $paymentMethod->delete();
            return response()->json(null, 204);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação.',
                'message' => $th->getMessage(),
            ]);
        }
    }
}
