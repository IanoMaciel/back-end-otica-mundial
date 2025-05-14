<?php

namespace App\Http\Controllers;

use App\Models\Surfacing;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SurfacingController extends Controller {

    protected $surfacing;
    public function __construct(Surfacing $surfacing) {
        $this->surfacing = $surfacing;
    }

    public function index(): JsonResponse {
        $surfacing = $this->surfacing
            ->query()
            ->orderBy('surfacing')
            ->get();

        return response()->json($surfacing);
    }

    public function store(Request $request): JsonResponse {
        $validatedData = $request->validate(
            $this->surfacing->rules(),
            $this->surfacing->messages(),
        );

        try {
            $surfacing = $this->surfacing->query()->create($validatedData);
            return response()->json($surfacing, 201);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação.',
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function show(int $id): JsonResponse {
        $surfacing = $this->surfacing->query()->find($id);

        if (!$surfacing) {
            return response()->json([
                'A surfaçagem informada não existe na base de dados.'
            ], 404);
        }
        return response()->json($surfacing);
    }

    public function update(Request $request, int $id): JsonResponse {
        $surfacing = $this->surfacing->query()->find($id);

        if (!$surfacing) {
            return response()->json([
                'A surfaçagem informada não existe na base de dados.'
            ], 404);
        }

        $validatedData = $request->validate(
            $this->surfacing->rules(),
            $this->surfacing->messages(),
        );


        $existsSurfacing = $this->surfacing->query()
            ->where('surfacing', $validatedData['surfacing'])
            ->where('id', '<>', $id)
            ->exists();

        if ($existsSurfacing) {
            return response()->json([
                'A surfaçagem já existe na base de dados.'
            ], 404);
        }

        try {
            $surfacing->update($validatedData);
            return response()->json($surfacing);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação.',
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function destroy(int $id): JsonResponse {
        $surfacing = $this->surfacing->query()->find($id);

        if (!$surfacing) {
            return response()->json([
                'A surfaçagem informada não existe na base de dados.'
            ], 404);
        }

        try {
            $surfacing->delete();
            return response()->json(null, 204);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação.',
                'message' => $th->getMessage(),
            ], 500);
        }
    }
}
