<?php

namespace App\Http\Controllers;

use App\Models\Index;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class IndexController extends Controller {
    protected $index;
    public function __construct(Index $index) {
        $this->index = $index;
    }

    public function index(): JsonResponse {
        $index = $this->index
            ->query()
            ->orderBy('index')
            ->get();

        return response()->json($index);
    }

    public function store(Request $request): JsonResponse {
        $validatedData = $request->validate(
            $this->index->rules(),
            $this->index->messages(),
        );

        try {
            $index = $this->index->query()->create($validatedData);
            return response()->json($index, 201);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação.',
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function show(int $id): JsonResponse {
        $index = $this->index->query()->find($id);

        if (!$index) {
            return response()->json([
                'O índice informado não existe na base de dados.'
            ], 404);
        }
        return response()->json($index);
    }

    public function update(Request $request, int $id): JsonResponse {
        $index = $this->index->query()->find($id);

        if (!$index) {
            return response()->json([
                'A surfaçagem informada não existe na base de dados.'
            ], 404);
        }

        $validatedData = $request->validate(
            $this->index->rules(true),
            $this->index->messages(),
        );

        $existsIndex = $this->index->query()
            ->where('index', $validatedData['index'])
            ->where('id', '<>', $id)
            ->exists();

        if ($existsIndex) {
            return response()->json([
                'O índice já existe na base de dados.'
            ], 409);
        }

        try {
            $index->update($validatedData);
            return response()->json($index);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação.',
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function destroy(int $id): JsonResponse {
        $index = $this->index->query()->find($id);

        if (!$index) {
            return response()->json([
                'O índice informado não existe na base de dados.'
            ], 404);
        }

        try {
            $index->delete();
            return response()->json(null, 204);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação.',
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function deleteAll(Request $request): JsonResponse {
        $validatedData = $request->validate(
            [
                'id' => 'required|array',
                'id.*' => 'integer|exists:indices,id',],
            [
                'id.required' => 'O campo id é obrigatório.',
                'id.*.integer' => 'O valor do campo id deve ser um número inteiro.',
                'id.*.exists' => 'O id não existe na base de dados.',
            ]
        );

        try {
            $this->index->query()->whereIn('id', $validatedData['id'])->delete();
            return response()->json(['message' => 'Registros excluídos com sucesso.']);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação',
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
