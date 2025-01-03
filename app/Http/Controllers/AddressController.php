<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AddressController extends Controller {
    protected $address;
    public function __construct(Address $address){
        $this->address = $address;
    }

    public function index(Request $request): JsonResponse {
        $perPage = $request->get('per_page', 10);
        $addresses = $this->address->query()->with('customer')->paginate($perPage);
        return response()->json($addresses);
    }

    public function store(Request $request): JsonResponse {
        $validatedData = $request->validate(
            $this->address->rules(),
            $this->address->messages()
        );

        try {
            $address = $this->address->query()->create($validatedData);
            return response()->json($address, 201);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação.',
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function show(int $id): JsonResponse {
        $address = $this->address->query()->with('customer')->find($id);

        if (!$address) {
            return response()->json([
                'error' => 'O Endereço informado não existe na base de dados.'
            ], 404);
        }

        return response()->json($address);
    }

    public function update(Request $request, int $id): JsonResponse {
        $address = $this->address->query()->with('customer')->find($id);

        if (!$address) {
            return response()->json([
                'error' => 'O Endereço informado não existe na base de dados.'
            ], 404);
        }

        $validatedData = $request->validate(
            $this->address->rules(),
            $this->address->messages()
        );

        try {
            $address->update($validatedData);
            return response()->json($address);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação.',
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function destroy(int $id): JsonResponse {
        $address = $this->address->query()->find($id);

        if (!$address) {
            return response()->json([
                'error' => 'O Endereço informado não existe na base de dados.'
            ], 404);
        }

        try {
            $address->delete();
            return response()->json(null, 204);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação.',
                'message' => $th->getMessage(),
            ], 500);
        }
    }
}
