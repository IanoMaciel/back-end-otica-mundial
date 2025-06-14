<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BrandController extends Controller {

    protected $brand;
    public function __construct(Brand $brand) {
        $this->brand = $brand;
    }

    public function index(): JsonResponse {
        return response()->json($this->brand->query()->orderBy('brand')->get());
    }

    public function store(Request $request): JsonResponse {
        $validatedData = $request->validate(
            $this->brand->rules(),
            $this->brand->messages()
        );

        try {
            $brand = $this->brand->query()->create($validatedData);
            return response()->json($brand, 201);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação.',
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function show(int $id): JsonResponse {
        $brand = $this->brand->query()->find($id);

        if (!$brand) {
            return response()->json([
                'error' => 'A Grife selecionada não existe na base de dados.'
            ], 404);
        }

        return response()->json($brand);
    }

    public function update(Request $request, int $id): JsonResponse {
        $brand = $this->brand->query()->find($id);

        if (!$brand) {
            return response()->json([
                'error' => 'A Grife selecionada não existe na base de dados.'
            ], 404);
        }

        $validatedData = $request->validate(
            $this->brand->rules(true),
            $this->brand->messages()
        );

        $materialExists = $this->brand->query()
            ->where('brand', $validatedData['brand'])
            ->where('id', '<>', $id)
            ->exists();

        if ($materialExists) {
            return response()->json([
                'error' => 'Grife já cadastrado na base de dados.'
            ], 409);
        }

        try {
            $brand->update($validatedData);
            return response()->json($brand);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação.',
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function destroy(int $id): JsonResponse {
        $brand = $this->brand->query()->find($id);

        if (!$brand) {
            return response()->json([
                'error' => 'A Grife selecionada não existe na base de dados.'
            ], 404);
        }

        try {
            $brand->delete();
            return response()->json(null, 204);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação',
                'message' => $th->getMessage(),
            ], 500);
        }
    }
}
