<?php

namespace App\Http\Controllers;

use App\Models\Diameter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DiameterController extends Controller {
    protected $diameter;
    public function __construct(Diameter $diameter) {
        $this->diameter = $diameter;
    }

    public function index(): JsonResponse {
        $diameter = $this->diameter
            ->query()
            ->orderBy('diameter')
            ->get();

        return response()->json($diameter);
    }

    public function store(Request $request): JsonResponse {
        $validatedData = $request->validate(
            $this->diameter->rules(),
            $this->diameter->messages(),
        );

        try {
            $diameter = $this->diameter->query()->create($validatedData);
            return response()->json($diameter, 201);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação.',
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function show(int $id): JsonResponse {
        $diameter = $this->diameter->query()->find($id);

        if (!$diameter) {
            return response()->json([
                'O diâmetro informado não existe na base de dados.'
            ], 404);
        }
        return response()->json($diameter);
    }

    public function update(Request $request, int $id): JsonResponse {
        $diameter = $this->diameter->query()->find($id);

        if (!$diameter) {
            return response()->json([
                'O diâmetro informado não existe na base de dados.'
            ], 404);
        }

        $validatedData = $request->validate(
            $this->diameter->rules(true),
            $this->diameter->messages(),
        );

        $existsDiameter = $this->diameter->query()
            ->where('diameter', $validatedData['diameter'])
            ->where('id', '<>', $id)
            ->exists();

        if ($existsDiameter) {
            return response()->json([
                'O diameter já existe na base de dados.'
            ], 409);
        }

        try {
            $diameter->update($validatedData);
            return response()->json($diameter);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação.',
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function destroy(int $id): JsonResponse {
        $diameter = $this->diameter->query()->find($id);

        if (!$diameter) {
            return response()->json([
                'O diâmetro informado não existe na base de dados.'
            ], 404);
        }

        try {
            $diameter->delete();
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
                'id.*' => 'integer|exists:diameters,id',],
            [
                'id.required' => 'O campo id é obrigatório.',
                'id.*.integer' => 'O valor do campo id deve ser um número inteiro.',
                'id.*.exists' => 'O id não existe na base de dados.',
            ]
        );

        try {
            $this->diameter->query()->whereIn('id', $validatedData['id'])->delete();
            return response()->json(['message' => 'Registros excluídos com sucesso.']);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação',
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
