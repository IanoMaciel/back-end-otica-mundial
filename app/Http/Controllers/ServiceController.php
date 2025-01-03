<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ServiceController extends Controller {

    protected $service;
    public function __construct(Service $service){
        $this->service = $service;
    }

    public function index(Request $request): JsonResponse {
        $query = $this->service->query()->orderBy('name');
        $perPage = $request->get('per_page', 10);
        $services = $query->paginate($perPage);
        return response()->json($services);
    }

    public function store(Request $request): JsonResponse {
        $validatedData = $request->validate(
            $this->service->rules(),
            $this->service->messages()
        );

        try {
            $service = $this->service->query()->create($validatedData);
            return response()->json($service, 201);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação.',
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function show(int $id): JsonResponse {
        $service = $this->service->query()->find($id);
        if (!$service) {
            return response()->json([
                'error' => 'O Serviço informado não existe na base de dados.'
            ], 404);
        }
        return response()->json($service);
    }

    public function update(Request $request, int $id): JsonResponse {
        $service = $this->service->query()->find($id);
        if (!$service) {
            return response()->json([
                'error' => 'O Serviço informado não existe na base de dados.'
            ], 404);
        }

        $validatedData = $request->validate(
            $this->service->rules(true),
            $this->service->messages()
        );

        $nameExists = $this->service->query()
            ->where('name', $validatedData['name'])
            ->where('id', '<>', $id)
            ->exists();

        if ($nameExists) {
            return response()->json([
                'error' => 'O Nome informado já está cadastrado na base de dados. '
            ], 409);
        }

        try {
            $service->update($validatedData);
            return response()->json($service);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação.',
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function destroy(int $id): JsonResponse {
        $service = $this->service->query()->find($id);
        if (!$service) {
            return response()->json([
                'error' => 'O Serviço informado não existe na base de dados.'
            ], 404);
        }

        try {
            $service->delete();
            return response()->json(null, 204);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação.',
                'message' => $th->getMessage(),
            ], 500);
        }
    }
}
