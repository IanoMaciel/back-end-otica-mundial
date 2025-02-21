<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\ServiceOrder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ServiceOrderController extends Controller {

    protected $serviceOrder;
    public function __construct(ServiceOrder $serviceOrder) {
        $this->serviceOrder = $serviceOrder;
    }

    public function exportServiceOrder(int $id) {
        $serviceOrder = $this->serviceOrder->query()->with('sale')->find($id);
        return view('pdf.service_order', compact('serviceOrder'));
    }



    public function store(Request $request): JsonResponse {
        $validatedData = $request->validate(
            $this->serviceOrder->rules(),
            $this->serviceOrder->messages()
        );

        try {
            $serviceOrder = $this->serviceOrder->query()->create($validatedData);
            return response()->json($serviceOrder);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação.',
                'message' => $th->getMessage()
            ]);
        }
    }
}
