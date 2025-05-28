<?php

namespace App\Http\Controllers;

use App\Models\Cancellation;
use App\Models\Customer;
use App\Models\Sale;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Nette\Schema\ValidationException;

class CancellationController extends Controller {
    protected $cancellation;
    public function __construct(Cancellation $cancellation) {
        $this->cancellation = $cancellation;
    }

    public function store(Request $request): JsonResponse {
        $validatedData = $request->validate(
            $this->cancellation->rules(),
            $this->cancellation->messages(),
        );

        try {
            return DB::transaction(function () use ($validatedData) {
                $sale = Sale::query()->find($validatedData['sale_id']);
                if ($sale->status === 'Cancelado') {
                    return response()->json([
                        'error' => 'Esta venda já foi cancelada',
                    ], 409);
                }
                // Step 2: Atualizar o status da venda
                $sale->update(['status' => 'Cancelado']);

                // Step 3: Atualizar a flag do customer (se existe)
                if ($sale->customer_id) {
                    $customer = Customer::query()->find($sale->customer_id);
                    if ($customer) {
                        $customer->update(['flag' => $validatedData['flag']]);
                    }
                }

                // Step 4: Criar o registro de cancelamento
                $cancellation = $this->cancellation->query()->create($validatedData);

                // Carregar relacionamentos corretos
                return response()->json(
                    $cancellation->load(['sales', 'users']),
                    201
                );

            });
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Dados inválidos.',
                'message' => $e->getMessage(),
                'errors' => $e->errors(),
            ], 422);

        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação.',
                'message' => $th->getMessage(),
            ], 500);
        }
    }
}
