<?php

namespace App\Http\Controllers;

use App\Models\Laboratory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LaboratoryController extends Controller {

    protected $laboratory;
    public function __construct(Laboratory $laboratory) {
        $this->laboratory = $laboratory;
    }

    public function index(): JsonResponse {
        return response()->json($this->laboratory->query()->orderBy('laboratory')->get());
    }

    public function store(Request $request): JsonResponse {
        $validatedData = $request->validate(
            $this->laboratory->rules(),
            $this->laboratory->messages(),
        );

        try {
            $laboratory = $this->laboratory->query()->create($validatedData);
            return response()->json($laboratory, 201);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação',
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function show(int $id): JsonResponse {
        $laboratory = $this->laboratory->query()->find($id);

        if (!$laboratory) {
            return response()->json([
                'error' => 'O laboratório informado não existe na base de dados.',
            ], 404);
        }

        return response()->json($laboratory);
    }

    public function update(Request $request, int $id): JsonResponse {
        $laboratory = $this->laboratory->query()->find($id);

        if (!$laboratory) {
            return response()->json([
                'error' => 'O laboratório informado não existe na base de dados.',
            ], 404);
        }

        $validatedData = $request->validate(
            $this->laboratory->rules(true),
            $this->laboratory->messages(),
        );

        $laboratoryExists = $this->laboratory->query()
            ->where('laboratory', $validatedData['laboratory'])
            ->where('id', '<>', $id)
            ->exists();

        if ($laboratoryExists) {
            return response()->json([
                'error' => 'O laboratório informado já existe na base de dados.',
            ], 422);
        }

        try {
            $laboratory->update($validatedData);
            return response()->json($laboratory);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação',
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function destroy(int $id): JsonResponse {
        $laboratory = $this->laboratory->query()->find($id);

        if (!$laboratory) {
            return response()->json([
                'error' => 'O laboratório informado não existe na base de dados.',
            ], 404);
        }

        try {
            $laboratory->delete();
            return response()->json(null, 204);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação',
                'message' => $th->getMessage(),
            ]);
        }
    }
}
