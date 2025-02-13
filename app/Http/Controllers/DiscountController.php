<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DiscountController extends Controller {
    protected $discount;
    public function __construct(Discount $discount) {
        $this->discount = $discount;
    }

    public function index() {
        return $this->discount->all();
    }

    public function store(Request $request): JsonResponse {
        $validatedData = $request->validate($this->discount->rules(), $this->discount->messages());
        try {
            $discount = $this->discount->query()->create($validatedData);
            return response()->json($discount, 201);
        }  catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação.',
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function show(int $id): JsonResponse {
        $discount = $this->discount->query()->find($id);

        if (!$discount) {
            return response()->json([
                'error' => 'O desconto informado não existe na base de dados.'
            ], 404);
        }

        return response()->json($discount);
    }

    public function update(Request $request, int $id): JsonResponse {
        $discount = $this->discount->query()->find($id);

        if (!$discount) {
            return response()->json([
                'error' => 'O desconto informado não existe na base de dados.'
            ], 404);
        }

        $validatedData = $request->validate($this->discount->rules(true), $this->discount->messages());

        $discountExists = $this->discount->query()
            ->where('discount_type', $validatedData['discount_type'])
            ->where('id', '<>', $id)
            ->exists();

        if ($discountExists) {
            return response()->json([
                'error' => 'O nome informado para o desconto já existe na base de dados.'
            ], 422);
        }

        try {
            $discount->update($validatedData);
            return response()->json($discount);
        }  catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação.',
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function destroy(int $id): JsonResponse {
        $discount = $this->discount->query()->find($id);

        if (!$discount) {
            return response()->json([
                'error' => 'O desconto informado não existe na base de dados.'
            ], 404);
        }

        try {
            $discount->delete();
            return response()->json(null, 204);
        }  catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação.',
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
