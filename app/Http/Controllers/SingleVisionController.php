<?php

namespace App\Http\Controllers;

use App\Models\SingleVision;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SingleVisionController extends Controller {

    protected $singleVision;
    public function __construct(SingleVision $singleVision) {
        $this->singleVision = $singleVision;
    }

    public function index() {
        return $this->singleVision->all();
    }

    public function Show(int $id): JsonResponse {
        $singleVision = $this->singleVision->query()->with('lens')->find($id);
        if (!$singleVision) {
            return response()->json([
                'error' => 'A lente informada não existe na base de dados.',
            ], 404);
        }
        return response()->json($singleVision);
    }

    public function update(Request $request, int $id): JsonResponse {
        $singleVision = $this->singleVision->query()->with('lens')->find($id);
        if (!$singleVision) {
            return response()->json([
                'error' => 'A lente informada não existe na base de dados.',
            ], 404);
        }

        $validatedData = $request->validate(
            $this->singleVision->rules(true),
            $this->singleVision->messages(),
        );

        try {
            $singleVision->update($validatedData);
            return response()->json($singleVision);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação.',
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function destroy(int $id): JsonResponse {
        $singleVision = $this->singleVision->query()->find($id);
        if (!$singleVision) {
            return response()->json([
                'error' => 'A lente informada não existe na base de dados.',
            ], 404);
        }

        try {
            $singleVision->delete();
            return response()->json(null, 204);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação.',
                'message' => $th->getMessage(),
            ], 500);
        }
    }
}
