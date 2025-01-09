<?php

namespace App\Http\Controllers;

use App\Models\Frame;
use App\Models\PaymentMethod;
use App\Models\Sale;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SaleController extends Controller {

    protected $sale;
    public function __construct(Sale $sale) {
        $this->sale = $sale;
    }

    public function index(Request $request): JsonResponse {
        $query = $this->sale->with('customer', 'user', 'paymentMethod', 'frames', 'services');
        $perPage = $request->get('per_page', 10);
        $sales = $query->paginate($perPage);
        return response()->json($sales);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse {
        $validatedData = $request->validate(
            $this->sale->rules(),
            $this->sale->messages(),
        );

        $user = User::query()->find($validatedData['user_id']);
        $discountUser = $user->discount ?: null;
        $discountSale = $validatedData['discount'] ?: null;

        $paymentMethod = PaymentMethod::query()->find($validatedData['payment_method_id']);

        if (isset($discountSale) && $discountSale > $discountUser) {
            return response()->json([
                'error' => 'O desconto deve ser menor ou igual a '. $discountUser,
            ], 422);
        }

        try {

            $sale = $this->sale->query()->create($validatedData);
            $totalAmount = 0;
            foreach ($validatedData['items'] as $item) {
                $model = $item['type'] === 'frame' ? Frame::class : Service::class;
                $sellable = $model::query()->find($item['id']);

                if (!$sellable) {
                    return response()->json([
                        'error' => 'O item informado não existe na base de dados.',
                    ], 404);
                }

                if ($item['type'] === 'frame' && $sellable->amount < $item['quantity']) {
                    return response()->json(['error' => 'Ops! O produto informado não possui estoque para realizar a venda.'], 422);
                }

                $sale->items()->create([
                    'sellable_type' => $model,
                    'sellable_id' => $sellable->id,
                    'quantity' => $item['quantity'],
                    'price' => $sellable->price,
                ]);

                if ($item['type'] === 'frame') {
                    $sellable->amount -= $item['quantity'];
                    $sellable->save();
                }

                $totalAmount += $sellable->price * $item['quantity'];
            }

            $sale->total_amount = $totalAmount;
            if ($paymentMethod->payment_method != 'Crediário da Loja') {
                $sale->status = 'Pago';
            }
            $sale->save();

            return response()->json($sale->load(['customer', 'user', 'paymentMethod', 'frames', 'services']));

        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação',
                'message' => $th->getMessage(),
            ]);
        }
    }
}
