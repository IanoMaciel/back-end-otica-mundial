<?php

namespace App\Http\Controllers;

use App\Models\Sensitivity;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SensitivityController extends Controller {

    protected $sensitivity;
    public function __construct(Sensitivity $sensitivity) {
        $this->sensitivity = $sensitivity;
    }

    public function index(): JsonResponse {
        return response()->json($this->sensitivity->query()->orderBy('sensitivity')->get());
    }

    public function store(Request $request): JsonResponse {
        $validatedData = $request->validate(
            $this->sensitivity->rules(),
            $this->sensitivity->messages(),
        );

        try {
            $sensitivity = $this->sensitivity->query()->create($validatedData);
            return response()->json($sensitivity, 201);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação',
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function show(int $id): JsonResponse {
        $sensitivity = $this->sensitivity->query()->find($id);
        if (!$sensitivity) {
            return response()->json([
                'error' => 'A sensibilidade informada não existe na base de dados.',
            ], 404);
        }
        return response()->json($sensitivity);
    }

    public function update(Request $request, int $id): JsonResponse {
        $sensitivity = $this->sensitivity->query()->find($id);
        if (!$sensitivity) {
            return response()->json([
                'error' => 'A sensibilidade informada não existe na base de dados.',
            ], 404);
        }

        $validatedData = $request->validate(
            $this->sensitivity->rules(true),
            $this->sensitivity->messages(),
        );

        $sensitivityExists = $this->sensitivity->query()
            ->where('sensitivity', $validatedData['sensitivity'])
            ->where('id', '<>', $id)
            ->exists();

        if ($sensitivityExists) {
            return response()->json([
                'error' => 'A sensibilidade informada já existe na base de dados.'
            ], 422);
        }

        try {
            $sensitivity->update($validatedData);
            return response()->json($sensitivity);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação',
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function destroy(int $id): JsonResponse {
        $sensitivity = $this->sensitivity->query()->find($id);
        if (!$sensitivity) {
            return response()->json([
                'error' => 'A sensibilidade informada não existe na base de dados.',
            ], 404);
        }

        try {
            $sensitivity->delete();
            return response()->json(null, 204);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação',
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function deleteAll(Request $request): JsonResponse {
        $validatedData = $request->validate(
            [
                'id' => 'required|array',
                'id.*' => 'integer|exists:sensitivities,id',],
            [
                'id.required' => 'O campo id é obrigatório.',
                'id.*.integer' => 'O valor do campo id deve ser um número inteiro.',
                'id.*.exists' => 'O id não existe na base de dados.',
            ]
        );

        try {
            $this->sensitivity->query()->whereIn('id', $validatedData['id'])->delete();
            return response()->json(['message' => 'Registros excluídos com sucesso.']);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação',
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
