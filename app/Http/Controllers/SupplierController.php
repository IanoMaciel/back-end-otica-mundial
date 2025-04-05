<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SupplierController extends Controller {

    protected $supplier;

    public function __construct(Supplier $supplier){
        $this->supplier = $supplier;
    }

    public function getAll(): JsonResponse {
        return response()->json($this->supplier->query()->orderBy('name')->get());
    }


    public function index(Request $request): JsonResponse {
        $query = $this->supplier->query()->orderBy('name');

        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            });
        }

        $perPage = $request->get('per_page', 10);
        $suppliers = $query->paginate($perPage);

        return response()->json($suppliers);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse {
        $validatedData = $request->validate(
            $this->supplier->rules(),
            $this->supplier->messages()
        );

        try {
            $supplier = $this->supplier->query()->create($validatedData);
            return response()->json($supplier, 201);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Error ao processar a solicitação.',
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse {
        $supplier = $this->supplier->query()->find($id);
        if (!$supplier) return response()->json(['error' => 'O Fornecedor selecionado não existe na base de dados.'], 404);
        return response()->json($supplier);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse {
        $supplier = $this->supplier->query()->find($id);
        if (!$supplier) return response()->json(['error' => 'O Fornecedor selecionado não existe na base de dados.'], 404);

        $validatedData = $request->validate(
            $this->supplier->rules(true),
            $this->supplier->messages()
        );

        $nameExists = $this->supplier->query()
            ->where('name', $validatedData['name'])
            ->where('id', '<>', $id)
            ->exists();

        if ($nameExists) return response()->json(['Error' => 'Fornecedor já cadastrado na base de dados.'], 409);

        try {
            $supplier->update($validatedData);
            return response()->json($supplier);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação',
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse {
        $supplier = $this->supplier->query()->find($id);
        if (!$supplier) return response()->json(['error' => 'O Fornecedor selecionado não existe na base de dados.'], 404);

        try {
            $supplier->delete();
            return response()->json(null, 204);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação',
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
