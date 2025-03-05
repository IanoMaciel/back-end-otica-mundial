<?php

namespace App\Http\Controllers;


use App\Models\CashPromotion;
use App\Models\CreditPromotion;
use App\Models\Promotion;
use App\Models\PromotionItem;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PromotionController extends Controller {

    protected $promotion;
    public function __construct(Promotion $promotion) {
        $this->promotion = $promotion;
    }

    public function store(Request $request): JsonResponse {
        $validatedData = $request->validate(
            $this->promotion->rules(),
            $this->promotion->messages(),
        );

        try {

            $promotion = $this->promotion->query()->create($validatedData);

            foreach ($validatedData['creditPromotions'] as $creditPromotion) {
                CreditPromotion::query()->create([
                    'promotion_id' => $promotion->id,
                    'installment' => $creditPromotion['installment'],
                    'discount' => $creditPromotion['discount'],
                ]);
            }

            foreach ($validatedData['cashPromotions'] as $cashPromotion) {
                CashPromotion::query()->create([
                    'promotion_id' => $promotion->id,
                    'form_payment_id' => $cashPromotion['form_payment_id'],
                    'discount' => $cashPromotion['discount'],
                ]);
            }

            foreach ($validatedData['promotionItems'] as $promotionItem) {
                PromotionItem::query()->create([
                    'promotion_id' => $promotion->id,
                    'promotionable_type' => $promotionItem['type'],
                    'promotionable_id' => $promotionItem['id']
                ]);
            }

            return response()->json($promotion->load('creditPromotions', 'cashPromotions', 'cashPromotions.formPayment', 'promotionItems' ), 201);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação.',
               'message' => $th->getMessage()
            ]);
        }
    }
}
