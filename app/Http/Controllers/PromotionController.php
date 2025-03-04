<?php

namespace App\Http\Controllers;


use App\Models\CreditPromotion;
use App\Models\Promotion;
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

        foreach ($validatedData['creditPromotions'] as $creditPromotion) {
            dd($creditPromotion);
        }

        try {

            $promotion = $this->promotion->query()->create($validatedData);


            foreach ($validatedData['creditPromotions'] as $creditPromotion) {
                CreditPromotion::query()->create([
                    'promotion_id' => $promotion->id,
                    'installment' => $creditPromotion->installment,
                    'discount' => $creditPromotion->discount,
                ]);
            }

            foreach ($validatedData['cashPromotions'] as $cashPromotion) {
                CreditPromotion::query()->create([
                    'promotion_id' => $promotion->id,
                    'form_payment_id' => $cashPromotion->form_payment_id,
                    'discount' => $cashPromotion->discount,
                ]);
            }

            return response()->json($promotion->load('creditPromotions', 'cashPromotions'), 201);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação.',
               'message' => $th->getMessage()
            ]);
        }
    }
}
