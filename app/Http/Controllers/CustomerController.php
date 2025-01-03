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

    public function index(Request $request): JsonResponse {
        $query = $this->customer->query()->with('agreements')->orderBy('full_name');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
               $q->where('full_name', 'like', '%' . $search . '%')
                   ->orWhere('cpf', 'like', '%' . $search . '%');
            });
        }

        $perPage = $request->get('per_page', 100);
        $customers = $query->paginate($perPage);
        return response()->json($customers);
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

    public function show(int $id): JsonResponse {
        $customer = $this->customer->query()->with('agreements')->find($id);
        if (!$customer) {
            return response()->json([
                'error' => 'O cliente informado não existe na base de dados.'
            ], 404);
        }
        return response()->json($customer);
    }

    public function update(Request $request, int $id): JsonResponse {
        $customer = $this->customer->query()->with('agreements')->find($id);
        if (!$customer) {
            return response()->json([
                'error' => 'O cliente informado não existe na base de dados.'
            ], 404);
        }

        $validatedData = $request->validate($this->customer->rules(true), $this->customer->messages());

        $cpfExists = $this->customer->query()
            ->where('cpf', $validatedData['cpf'])
            ->where('id', '<>', $id)
            ->exists();

        if ($cpfExists) {
            return response()->json([
                'error' => 'O CPF informado já está cadastrado na base de dados.'
            ], 409);
        }

        try {
            $customer->update($validatedData);
            return response()->json($customer);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Error ao processar a solicitação',
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function destroy(int $id): JsonResponse {
        $customer = $this->customer->query()->with('agreements')->find($id);
        if (!$customer) {
            return response()->json([
                'error' => 'O cliente informado não existe na base de dados.'
            ], 404);
        }

        try {
            $customer->delete();
            return response()->json(null, 204);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Error ao processar a solicitação',
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
