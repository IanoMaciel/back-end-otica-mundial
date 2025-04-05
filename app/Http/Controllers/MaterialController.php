<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MaterialController extends Controller {

    protected $material;
    public function __construct(Material $material) {
        $this->material = $material;
    }

    public function index(Request $request): JsonResponse {
        return response()->json($this->material->query()->orderBy('material')->get());
    }

    public function store(Request $request): JsonResponse {
        $validatedData = $request->validate($this->material->rules(), $this->material->messages());

        try {
            $material = $this->material->query()->create($validatedData);
            return response()->json($material, 201);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação',
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function show(int $id): JsonResponse {
        $material = $this->material->query()->find($id);

        if (!$material) {
            return response()->json([
                'error' => 'O Material selecionado não existe na base de dados.'
            ], 404);
        }

        return response()->json($material);
    }

    public function update(Request $request, int $id): JsonResponse {
        $material = $this->material->query()->find($id);

        if (!$material) {
            return response()->json([
                'error' => 'O Material selecionado não existe na base de dados.'
            ], 404);
        }

        $validatedData = $request->validate(
            $this->material->rules(true),
            $this->material->messages()
        );

        $materialExists = $this->material->query()
            ->where('material', $validatedData['material'])
            ->where('id', '<>', $id)
            ->exists();

        if ($materialExists) {
            return response()->json([
                'error' => 'Material já cadastrado na base de dados.'
            ], 409);
        }

        try {
            $material->update($validatedData);
            return response()->json($material);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação.',
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function destroy(int $id): JsonResponse {
        $material = $this->material->query()->find($id);

        if (!$material) {
            return response()->json([
                'error' => 'O Material selecionado não existe na base de dados.'
            ], 404);
        }

        try {
            $material->delete();
            return response()->json(null, 204);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação',
                'message' => $th->getMessage(),
            ], 500);
        }
    }
}
