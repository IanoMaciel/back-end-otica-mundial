<?php

namespace App\Http\Controllers;

use App\Models\CashPromotion;
use App\Models\CreditPromotion;
use App\Models\Discount;
use App\Models\Frame;
use App\Models\Lens;
use App\Models\PaymentMethod;
use App\Models\Sale;
use App\Models\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SaveSaleController extends Controller {
    protected $sale;

    protected const MODEL_TYPES = [
        'frame' => Frame::class,
        'lens' => Lens::class,
        'service' => Service::class,
    ];

    protected const PAYMENT_TYPES = [
        'chash' => CashPromotion::class,
        'credit' => CreditPromotion::class,
    ];

    public function __construct(Sale $sale) {
        $this->sale = $sale;
    }

    public function createSale(Request $request): JsonResponse {
        $validatedData = $request->validate(
            $this->sale->rules(),
            $this->sale->messages(),
        );

        if ($this->validations($validatedData)) {
            return $this->validations($validatedData);
        }

        $paymentMethod = PaymentMethod::query()->find($validatedData['payment_method_id']);

        try {
            $sale = $this->sale->query()->create($validatedData);

            $totalAmount = 0;
            foreach ($validatedData['items'] as $item) {

                if ($item['type'] === 'frame')
                    $model = Frame::class;
                else if ($item['type'] === 'lens')
                    $model = Lens::class;
                else $model = Service::class;

                $sellable = $model::query()->find($item['id']);

                if (!$sellable) {
                    return response()->json([
                        'error' => 'O item informado não existe na base de dados.',
                    ], 404);
                }

                $discount = $item['discount'] ?? null;

                $itemTotal = ($sellable->price - ($sellable->price * ($discount/100))) * $item['quantity'];

                $promotionData = $item['promotions'][0] ?? [];

                $mapTypes = [
                    'cash' => 'App\Models\CashPromotion',
                    'credit' => 'App\Models\CreditPromotion',
                ];

                $sale->items()->create([
                    'sellable_type' => $model,
                    'sellable_id' => $sellable->id,
                    'quantity' => $item['quantity'],
                    'price' => $sellable->price,
                    'total' => $itemTotal,
                    'promotion_id' => $promotionData['promotion_id'] ?? null,
                    'paymentable_type' => isset($promotionData['paymentable_type']) ? ($mapTypes[$promotionData['paymentable_type']] ?? '') : '',
                    'paymentable_id' => $promotionData['paymentable_id'] ?? 0,
                    'store_credit' => $promotionData['store_credit'] ?? null,
                    'user_id' => $item['user_id'] ?? null
                ]);

                if ($item['type'] === 'frame') {
                    $sellable->amount -= $item['quantity'];
                    $sellable->save();
                }

                $totalAmount += $itemTotal;
            }
            $sale->total_amount = $totalAmount;

            if ($paymentMethod->payment_method === 'Crediário da Loja') {
                $sale->status = 'Pendente';
            } else {
                $sale->status = 'Pago';
            }

            $sale->save();

            return response()->json($sale->load([
                'customer',
                'user',
                'paymentMethod',
                'frames',
                'services',
                'lenses',
                'cashPromotions',
                'creditPromotions'
            ]), 201);

        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação',
                'message' => $th->getMessage(),
            ]);
        }
    }

    private function validations(array $validatedData) {
        foreach ($validatedData['items'] as $item) {
            /**
             * 5 - Vendedor
             * 6 - Gerente
             * 7 - Administrador
             */
            $discountID = $item['discount_id'] ?? null;
            $discount = $item['discount'] ?? null;

            if ($item['type'] === 'frame') {
                $frame = Frame::query()->find($item['id']);

                if (!$frame) {
                    return response()->json(['error' => 'O produto informado não existe na base de dados.'], 404);
                }

//                if ($discount && $discountID) {
//                    $discount_type = Discount::query()->find($discountID)->getAttribute('discount_type');
//
//                    if ($discount_type === 'Vendedor' && $discount > $frame->brands->discount) {
//
//                    } else if ($discount_type === 'Gerente') {
//
//                    } else if ($discount_type === 'Administrador') {
//
//                    }
//                }

//                if ($discount && $discount > $frame->brands->discount) {
//                    return response()->json([
//                        'error' => 'O desconto aplicado na armação deve ser igual ou inferior a ' . $frame->brands->discount . '%',
//                    ], 422);
//                }

                if ($frame->amount < $item['quantity']) {
                    return response()->json([
                        'error' => 'O armção (Código da armação: ' . $frame->code . ') não possui estoque suficiente para realizar a venda.',
                    ], 422);
                }
            }

            if ($item['type'] === 'lens') {
                $lens = Lens::query()->find($item['id']);

                if (!$lens) {
                    return response()->json(['error' => 'A lente informada não existe na base de dados.'], 404);
                }

                if ($discount && $discount > $lens->discount) {
                    return response()->json([
                        'error' => 'O desconto aplicado na lente deve ser igual ou inferior a ' . $lens->discount . '%',
                    ], 422);
                }
            }
        }
        return null;
    }
}
