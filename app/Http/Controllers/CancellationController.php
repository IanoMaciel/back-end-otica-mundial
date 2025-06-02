<?php

namespace App\Http\Controllers;

use App\Models\Cancellation;
use App\Models\Customer;
use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Nette\Schema\ValidationException;

class CancellationController extends Controller {
    protected $cancellation;
    public function __construct(Cancellation $cancellation) {
        $this->cancellation = $cancellation;
    }

    public function index(Request $request): JsonResponse {
        $date = $request->input('date');
        $numberAta = $request->input('number_ata');

        $cancellation = $this->cancellation->query()->with([
            'sale',
            'sale.customer',
            'sale.user:id,first_name,last_name',
            'sale.paymentMethod',
            'user:id,first_name,last_name',
        ])
            ->whereHas('sale', function ($query) use ($numberAta) {
                if ($numberAta) {
                    $query->where('status', 'Cancelado')
                        ->where('number_ata', 'LIKE', "%{$numberAta}%");
                }
            })

            ->orderBy('created_at', 'DESC');

        if ($date) {
            try {
                $parsedDate = Carbon::parse($date)->toDateString();
                $cancellation->whereDate('created_at', $parsedDate);
            } catch (\Exception $e) {
                return response()->json([
                    'error' => 'Formato de data inválido. Use o formato YYYY-MM-DD.',
                ], 422);
            }
        }

        $perPage = $request->get('per_page', 10);
        return response()->json($cancellation->paginate($perPage));
    }

    public function store(Request $request): JsonResponse {
        $validatedData = $request->validate(
            $this->cancellation->rules(),
            $this->cancellation->messages(),
        );

        $user = Auth::user();
        $validatedData = array_merge($validatedData, ['user_id' => $user->id]);

        try {
            return DB::transaction(function () use ($validatedData) {
                $sale = Sale::query()->find($validatedData['sale_id']);
                if ($sale->status === 'Cancelado') {
                    return response()->json([
                        'error' => 'Esta venda já foi cancelada',
                    ], 409);
                }

                $sale->update(['status' => 'Cancelado']);

                if ($sale->customer_id) {
                    $customer = Customer::query()->find($sale->customer_id);
                    $customer->update(['flag' => $validatedData['flag']]);
                }

                $cancellation = $this->cancellation->query()->create($validatedData);

                return response()->json($cancellation->load(['sale', 'user']), 201);
            });
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Dados inválidos.',
                'message' => $e->getMessage(),
            ], 422);

        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação.',
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function show(int $id): JsonResponse {
        $cancellation = $this->cancellation->query()
            ->with([
                'sale',
                'sale.customer',
                'sale.user:id,first_name,last_name',
                'sale.paymentMethod',
                'user:id,first_name,last_name',
            ])
            ->find($id);

        if (!$cancellation) {
            return response()->json([
                'error' => 'O cancelamento informado não existe na base de dados.'
            ], 404);
        }
        return response()->json($cancellation);
    }

    public function update(int $id): JsonResponse {
        $cancellation = $this->cancellation->query()->find($id);

        if (!$cancellation) {
            return response()->json([
                'error' => 'O cancelamento informado não existe na base de dados.'
            ], 404);
        }

        try {
            return response()->json($cancellation);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação',
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function destroy(int $id): JsonResponse {
        $cancellation = $this->cancellation->query()->find($id);

        if (!$cancellation) {
            return response()->json([
                'error' => 'O cancelamento informado não existe na base de dados.'
            ], 404);
        }

        try {
            $cancellation->delete();
            return response()->json(null, 204);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação',
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function deleteMultiple(Request $request): JsonResponse {
        $validatedData = $request->validate(
            [
                'id' => 'required|array',
                'id.*' => 'integer|exists:cancellations,id'
            ],
            [
                'id.required' => 'O campo id é obrigatório.',
                'id.array' => 'O campo id é do tipo array.',
                'id.*.integer' => 'Cada id deve ser um número inteiro.',
                'id.*.exists' => 'Um ou mais registros selecionados não existe na base de dados.'
            ]
        );

        try {
            $this->cancellation->query()->whereIn('id', $validatedData['id'])->delete();
            return response()->json(['message' => 'Registros excluídos com sucesso.']);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Error ao processar a soliciatação.',
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
