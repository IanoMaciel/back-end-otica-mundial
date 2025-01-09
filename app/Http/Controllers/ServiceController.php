<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller {
    protected $service;
    public function __construct(Service $service){
        $this->service = $service;
    }

    public function index(Request $request): JsonResponse {
        $query = $this->service->query()->orderBy('name');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
               $q->where('name', 'like', '%' . $search . '%');
            });
        }

        $perPage = $request->get('per_page', 10);
        $services = $query->paginate($perPage);

        return response()->json($services);
    }

    public function store(Request $request): JsonResponse {
        if (!$this->isAuthorization()) {
            return response()->json([
                'error' => 'Ops! Você não possui autorização para realizar está operação.'
            ], 403);
        }

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
        if (!$this->isAuthorization()) {
            return response()->json([
                'error' => 'Ops! Você não possui autorização para realizar está operação.'
            ], 403);
        }

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
        if (!$this->isAuthorization()) {
            return response()->json([
                'error' => 'Ops! Você não possui autorização para realizar está operação.'
            ], 403);
        }

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

    public function deleteMultiple(Request $request): JsonResponse {
        if (!$this->isAuthorization()) {
            return response()->json([
                'error' => 'Ops! Você não possui autorização para realizar está operação.'
            ], 403);
        }

        $validatedData = $request->validate(
            [
                'id' => 'required|array',
                'id.*' => 'integer|exists:services,id'
            ],
            [
                'id.required' => 'O campo id é obrigatório.',
                'id.array' => 'O campo id é do tipo array.',
                'id.*.integer' => 'Cada id deve ser um número inteiro.',
                'id.*.exists' => 'Um ou mais registros selecionados não existe na base de dados.'
            ]
        );

        try {
            $this->service->query()->whereIn('id', $validatedData['id'])->delete();
            return response()->json(['message' => 'Registros excluídos com sucesso.']);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Error ao processar a soliciatação.',
                'message' => $th->getMessage()
            ], 500);
        }
    }

    private function isAuthorization(): bool {
        $user = Auth::user();
        return $user->getAttribute('is_admin') || $user->getAttribute('is_manager');
    }
}
