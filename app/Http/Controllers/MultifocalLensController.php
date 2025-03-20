<?php

namespace App\Http\Controllers;

use App\Models\MultifocalLens;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MultifocalLensController extends Controller {
    protected $multifocalLens;
    public function __construct(MultifocalLens $multifocalLens) {
        $this->multifocalLens = $multifocalLens;
    }

    public function index() {
        return $this->multifocalLens->all();
    }

    public function show(int $id): JsonResponse {
        $multifocalLens = $this->multifocalLens->query()->with('lens')->find($id);

        if (!$multifocalLens) {
            return response()->json([
                'error' => 'A lente informada não existe na base de dados.',
            ], 404);
        }

        return response()->json($multifocalLens);
    }

    public function update(Request $request, int $id): JsonResponse {
        $multifocalLens = $this->multifocalLens->query()->find($id);

        if (!$multifocalLens) {
            return response()->json([
                'error' => 'A lente informada não existe na base de dados.',
            ], 404);
        }

        $validatedData = $request->validate(
            $this->multifocalLens->rules(true),
            $this->multifocalLens->messages(),
        );

        try {
            $multifocalLens->update($validatedData);
            return response()->json($multifocalLens);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação.',
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function destroy(int $id): JsonResponse {
        $multifocalLens = $this->multifocalLens->query()->find($id);

        if (!$multifocalLens) {
            return response()->json([
                'error' => 'A lente informada não existe na base de dados.',
            ], 404);
        }

        try {
            $multifocalLens->delete();
            return response()->json(null, 204);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação.',
                'message' => $th->getMessage(),
            ], 500);
        }
    }

}
