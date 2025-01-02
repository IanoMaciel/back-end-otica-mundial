<?php

namespace App\Http\Controllers;

use App\Models\Agreement;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AgreementController extends Controller {
    protected $agreement;
    public function __construct(Agreement $agreement) {
        $this->agreement = $agreement;
    }

    public function index(): JsonResponse {
        return response()->json($this->agreement->query()->get());
    }

    public function store(Request $request): JsonResponse {
        $validatedData = $request->validate($this->agreement->rules(), $this->agreement->messages());
        try {
            $agreement = $this->agreement->query()->create($validatedData);
            return response()->json($agreement, 201);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação.',
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function show(int $id): JsonResponse {
        $agreement = $this->agreement->query()->find($id);
        if (!$agreement) return response()->json(['error' => 'O Convênio selecionado não existe na base de dados.'], 404);
        return response()->json($agreement);
    }

    public function update(Request $request, int $id): JsonResponse {
        $agreement = $this->agreement->query()->find($id);
        if (!$agreement) return response()->json(['error' => 'O Convênio selecionado não existe na base de dados.'], 404);

        $validatedData = $request->validate($this->agreement->rules(true), $this->agreement->messages());

        $existsName = $this->agreement->query()
            ->where('agreement', $validatedData['agreement'])
            ->where('id', '<>', $id)
            ->exists();

        if ($existsName) return response()->json(['error' => 'O Convênio informado já está cadastrado na base de dados.'], 409);

        try {
            $agreement->update($validatedData);
            return response()->json($agreement);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação',
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function destroy(int $id): JsonResponse {
        $agreement = $this->agreement->query()->find($id);
        if (!$agreement) return response()->json(['error' => 'O Convênio selecionado não existe na base de dados.'], 404);

        try {
            $agreement->delete();
            return response()->json(null, 204);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação',
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
