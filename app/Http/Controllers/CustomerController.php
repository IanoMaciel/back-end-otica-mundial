<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CustomerController extends Controller {
    protected $customer;
    public function __construct(Customer $customer) {
        $this->customer = $customer;
    }

    public function store(Request $request): JsonResponse {
        $validatedData = $request->validate(
            $this->customer->rules(),
            $this->customer->messages(),
        );

        try {
            $customer = $this->customer->query()->create($validatedData);
            return response()->json($customer, 201);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação',
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
