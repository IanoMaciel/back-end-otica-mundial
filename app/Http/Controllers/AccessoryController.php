<?php

namespace App\Http\Controllers;

use App\Models\Accessory;
use App\ProductPrefix;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccessoryController extends Controller {
    protected $accessory;
    public function __construct(Accessory $accessory) {
        $this->accessory = $accessory;
    }

    public function index(Request $request): JsonResponse {
        $accessories = $this->accessory->query()->orderBy('created_at', 'desc');

        if ($search = $request->input('search')) {
            $accessories->where(function ($query) use ($search) {
                $query->where('name', 'LIKE', "%$search%")
                    ->orWhere('barcode', 'LIKE', "%$search%");
            });
        }

        $perPage = $request->get('per_page', 10);
        return response()->json($accessories->paginate($perPage));
    }

    public function store(Request $request): JsonResponse {
        $validatedData = $request->validate(
            $this->accessory->rules(),
            $this->accessory->messages(),
        );

        $validatedData = array_merge($validatedData, [
            'barcode' => $this->generateUniqueBarCode(ProductPrefix::ACCESSORIES),
        ]);

        try {
            $accessory = $this->accessory->query()->create($validatedData);
            return response()->json($accessory, 201);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação.',
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function show(int $id): JsonResponse {
        $accessory = $this->accessory->query()->find($id);

        if (!$accessory) {
            return response()->json([
                'error' => 'O acessório informado não existe na base de dados.'
            ], 404);
        }

        return response()->json($accessory);
    }

    public function update(Request $request, int $id): JsonResponse {
        $accessory = $this->accessory->query()->find($id);

        if (!$accessory) {
            return response()->json([
                'error' => 'O acessório informado não existe na base de dados.'
            ], 404);
        }

        $validatedData = $request->validate(
            $this->accessory->rules(true),
            $this->accessory->messages(),
        );

        $nameExists = $this->accessory->query()
            ->where('name', $validatedData['name'])
            ->where('id', '<>', $id)
            ->exists();

        if ($nameExists) {
            return response()->json([
                'error' => 'O acessório informado já existe na base de dados.'
            ], 422);
        }

        try {
            $accessory->update($validatedData);
            return response()->json($accessory);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação.',
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function destroy(int $id): JsonResponse {
        $accessory = $this->accessory->query()->find($id);

        if (!$accessory) {
            return response()->json([
                'error' => 'O acessório informado não existe na base de dados.'
            ], 404);
        }

        try {
            $accessory->delete();
            return response()->json(null, 204);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação.',
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    private function generateUniqueBarCode(string $prefix): string {
        do {
            $baseCode = $prefix . str_pad(random_int(0, 999999999), 9, '0', STR_PAD_LEFT);

            $sum = 0;

            for ($i = 0; $i < strlen($baseCode); $i++) {
                $sum += (int)$baseCode[$i] * ($i % 2 ? 3 : 1);
            }

            $checkDigit = (10 - ($sum % 10)) % 10;
            $barcode = $baseCode . $checkDigit;

        } while ($this->accessory->query()->where('barcode', $barcode)->exists());
        return $barcode;
    }

    public function deleteAll(Request $request): JsonResponse {
        if (!$this->auth()) {
            return response()->json([
                'error' => 'Ops! Você não possui autorização para realizar esta operação.'
            ], 403);
        }

        $validatedData = $request->validate(
            ['id' => 'required|array', 'id.*' => 'integer|exists:accessories,id'],
            ['id.required' => 'O campo id é obrigatório.', 'id.array' => 'O campo id é do tipo array.', 'id.*.integer' => 'O id deve ser um número inteiro.',  'id.*.exists' => 'Um ou mais registros selecionados não existe na base de dados.']
        );

        try {
            $this->accessory->query()->whereIn('id', $validatedData['id'])->delete();
            return response()->json(['message' => 'Registros excluídos com sucesso.']);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Error ao processar a soliciatação.',
                'message' => $th->getMessage()
            ], 500);
        }
    }

    private function auth(): bool {
        return (bool) Auth::user()->is_admin;
    }
}
