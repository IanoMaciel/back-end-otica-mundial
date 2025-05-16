<?php

namespace App\Http\Controllers;

use App\Models\Treatment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TreatmentController extends Controller {

    protected $treatment;
    public function __construct(Treatment $treatment){
        $this->treatment = $treatment;
    }

    public function index(): JsonResponse {
        return response()->json($this->treatment->query()->orderBy('treatment')->get());
    }

    public function store(Request $request): JsonResponse {
        $validatedData = $request->validate(
            $this->treatment->rules(),
            $this->treatment->messages(),
        );

        try {
            $treatment = $this->treatment->query()->create($validatedData);
            return response()->json($treatment, 201);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação',
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function show(int $id): JsonResponse {
        $treatment = $this->treatment->query()->find($id);
        if (!$treatment) {
            return response()->json([
                'error' => 'O tratamento informado não existe na base de dados.',
            ], 404);
        }
        return response()->json($treatment);
    }

    public function update(Request $request, int $id): JsonResponse {
        $treatment = $this->treatment->query()->find($id);

        if (!$treatment) {
            return response()->json([
                'error' => 'O tratamento informado não existe na base de dados.',
            ], 404);
        }

        $validatedData = $request->validate(
            $this->treatment->rules(true),
            $this->treatment->messages(),
        );

        $treatmentExists = $this->treatment->query()
            ->where('treatment', $validatedData['treatment'])
            ->where('id', '<>', $id)
            ->exists();

        if ($treatmentExists) {
            return response()->json([
                'error' => 'O tratamento informado já existe na base de dados.'
            ], 422);
        }

        try {
            $treatment->update($validatedData);
            return response()->json($treatment);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação',
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function destroy(int $id): JsonResponse {
        $treatment = $this->treatment->query()->find($id);

        if (!$treatment) {
            return response()->json([
                'error' => 'O tratamento informado não existe na base de dados.',
            ], 404);
        }
        try {
            $treatment->delete();
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
                'id.*' => 'integer|exists:treatments,id',],
            [
                'id.required' => 'O campo id é obrigatório.',
                'id.*.integer' => 'O valor do campo id deve ser um número inteiro.',
                'id.*.exists' => 'O id não existe na base de dados.',
            ]
        );

        try {
            $this->treatment->query()->whereIn('id', $validatedData['id'])->delete();
            return response()->json(['message' => 'Registros excluídos com sucesso.']);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação',
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
