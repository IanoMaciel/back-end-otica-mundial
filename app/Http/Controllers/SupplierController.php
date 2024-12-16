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


    /**
     * @param Request $request
     * @return JsonResponse
     */
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
            ]);
        }
    }
}
