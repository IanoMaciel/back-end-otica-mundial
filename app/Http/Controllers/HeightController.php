<?php

namespace App\Http\Controllers;

use App\Models\Height;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HeightController extends Controller {

    protected $height;
    public function __construct(Height $height) {
        $this->height = $height;
    }

    public function index(): JsonResponse {
        return response()->json($this->height->query()->orderBy('height')->get());
    }

    public function store(Request $request): JsonResponse {
        $validatedData = $request->validate(
            $this->height->rules(),
            $this->height->messages(),
        );

        try {
            $height = $this->height->query()->create($validatedData);
            return response()->json($height, 201);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação.',
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function show(int $id): JsonResponse {
        $height = $this->height->query()->find($id);

        if (!$height) {
            return response()->json([
                'A altura informado não existe na base de dados.'
            ], 404);
        }
        return response()->json($height);
    }

    public function update(Request $request, int $id): JsonResponse {
        $height = $this->height->query()->find($id);

        if (!$height) {
            return response()->json([
                'A altura informada não existe na base de dados.'
            ], 404);
        }

        $validatedData = $request->validate(
            $this->height->rules(true),
            $this->height->messages(),
        );

        $existsHeight = $this->height->query()
            ->where('height', $validatedData['height'])
            ->where('id', '<>', $id)
            ->exists();

        if ($existsHeight) {
            return response()->json([
                'O índice já existe na base de dados.'
            ], 409);
        }

        try {
            $height->update($validatedData);
            return response()->json($height);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação.',
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function destroy(int $id): JsonResponse {
        $height = $this->height->query()->find($id);

        if (!$height) {
            return response()->json([
                'A altura informado não existe na base de dados.'
            ], 404);
        }

        try {
            $height->delete();
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
                'id.*' => 'integer|exists:heights,id',],
            [
                'id.required' => 'O campo id é obrigatório.',
                'id.*.integer' => 'O valor do campo id deve ser um número inteiro.',
                'id.*.exists' => 'O id não existe na base de dados.',
            ]
        );

        try {
            $this->height->query()->whereIn('id', $validatedData['id'])->delete();
            return response()->json(['message' => 'Registros excluídos com sucesso.']);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação',
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
