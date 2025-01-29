<?php

namespace App\Http\Controllers;

use App\Models\TypeLens;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TypeLensController extends Controller {

    protected $typeLens;
    public function __construct(TypeLens $typeLens) {
        $this->typeLens = $typeLens;
    }

    public function index(): JsonResponse {
        return response()->json($this->typeLens->query()->get());
    }

    public function store(Request $request): JsonResponse {
        $validatedData = $request->validate(
            $this->typeLens->rules(),
            $this->typeLens->messages(),
        );

        try {
            $typeLens = $this->typeLens->query()->create($validatedData);
            return response()->json($typeLens, 201);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação',
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function show(int $id): JsonResponse {
        $typeLens = $this->typeLens->query()->find($id);
        if (!$typeLens) {
            return response()->json([
                'error' => 'O tipo de lente informado não existe na base de dados.',
            ], 404);
        }
        return response()->json($typeLens);
    }

    public function update(Request $request, int $id): JsonResponse {
        $typeLens = $this->typeLens->query()->find($id);

        if (!$typeLens) {
            return response()->json([
                'error' => 'O tipo de lente informado não existe na base de dados.',
            ], 404);
        }

        $validatedData = $request->validate(
            $this->typeLens->rules(true),
            $this->typeLens->messages(),
        );

        $typeLensExists = $this->typeLens->query()
            ->where('type_lens', $validatedData['type_lens'])
            ->where('id', '<>', $id)
            ->exists();

        if ($typeLensExists) {
            return response()->json([
                'error' => 'O tipo de lente informado já existe na base de dados.'
            ], 422);
        }

        try {
            $typeLens->update($validatedData);
            return response()->json($typeLens);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação',
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function destroy(int $id): JsonResponse {
        $typeLens = $this->typeLens->query()->find($id);
        if (!$typeLens) {
            return response()->json([
                'error' => 'O tipo de lente informado não existe na base de dados.',
            ], 404);
        }
        try {
            $typeLens->delete();
            return response()->json(null, 204);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação',
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
