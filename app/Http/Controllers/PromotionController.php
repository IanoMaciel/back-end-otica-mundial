<?php

namespace App\Http\Controllers;


use App\Models\CashPromotion;
use App\Models\CreditPromotion;
use App\Models\Filter;
use App\Models\Promotion;
use App\Models\PromotionItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PromotionController extends Controller {

    protected $promotion;
    public function __construct(Promotion $promotion) {
        $this->promotion = $promotion;
    }

    public function index(Request $request): JsonResponse {
        $promotions = $this->promotion->query()->with([
            'creditPromotions',
            'cashPromotions',
            'cashPromotions.formPayment',
            'promotionItems',
            'filters'
        ])->orderBy('created_at', 'desc');

        # filters
        if ($title = $request->input('title')) {
            $promotions->where(function ($query) use ($title) {
                $query->where('title', 'LIKE', "%$title");
            });
        }

        if ($status = $request->input('status')) {
            $promotions->where(function ($query) use ($status) {
               $query->where('status', 'LIKE', "%$status");
            });
        }

        if ($auth = $request->input('auth')) {
            $promotions->where(function ($query) use ($auth) {
                $query->where('auth', 'LIKE', "%$auth");
            });
        }

        $perPage = $request->get('per_page', 10);
        return response()->json($promotions->paginate($perPage));
    }

    public function store(Request $request): JsonResponse {
        $validatedData = $request->validate(
            $this->promotion->rules(),
            $this->promotion->messages(),
        );

        $dateStart = Carbon::parse($validatedData['start']);
        $dateCurrent = Carbon::now();

        # verifica se $dateStart é maior ou igual a $dateCurrent
        if ($dateStart->lte($dateCurrent)) {
            $validatedData = array_merge($validatedData, [
                'status' => 'Ativa'
            ]);
        }

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

            if(isset($validatedData['filters'])) {
                foreach ($validatedData['filters'] as $filter) {
                    Filter::query()->create([
                        'promotion_id' => $promotion->id,
                        'type' => $filter['type'],
                        'name' => $filter['name']
                    ]);
                }
            }

            return response()->json(
                $promotion->load(
                    'creditPromotions',
                    'cashPromotions',
                    'cashPromotions.formPayment',
                    'promotionItems',
                    'filters'
                ), 201
            );
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação.',
               'message' => $th->getMessage()
            ]);
        }
    }

    public function show(int $id): JsonResponse {
        $promotion = $this->promotion->query()->with([
            'creditPromotions',
            'cashPromotions',
            'cashPromotions.formPayment',
            'promotionItems',
            'filters'
        ])->find($id);

        if (!$promotion) {
            return response()->json([
                'error' => 'A promoção informada não existe na base de dados.'
            ], 404);
        }

        return response()->json($promotion);
    }

    public function update(Request $request, int $id): JsonResponse {
        $promotion = $this->promotion->query()->find($id);

        if (!$promotion) {
            return response()->json([
                'error' => 'A promoção informada não existe na base de dados.'
            ], 404);
        }

        $validatedData = $request->validate(
            $this->promotion->rules(),
            $this->promotion->messages(),
        );

        $dateStart = Carbon::parse($validatedData['start']);
        $dateCurrent = Carbon::now();

        # verifica se $dateStart é maior ou igual a $dateCurrent
        if ($dateStart->lte($dateCurrent)) {
            $validatedData = array_merge($validatedData, [
                'status' => 'Ativa'
            ]);
        }

        try {
            $promotion->update($validatedData);

            # Atualiza as promoções de crédito
            if (isset($validatedData['creditPromotions'])) {
                $promotion->creditPromotions()->delete();
                foreach ($validatedData['creditPromotions'] as $creditPromotion) {
                    CreditPromotion::query()->create([
                        'promotion_id' => $promotion->id,
                        'installment' => $creditPromotion['installment'],
                        'discount' => $creditPromotion['discount'],
                    ]);
                }
            }

            # Atualiza as promoções à vista
            if (isset($validatedData['cashPromotions'])) {
                $promotion->cashPromotions()->delete();
                foreach ($validatedData['cashPromotions'] as $cashPromotion) {
                    CashPromotion::query()->create([
                        'promotion_id' => $promotion->id,
                        'form_payment_id' => $cashPromotion['form_payment_id'],
                        'discount' => $cashPromotion['discount'],
                    ]);
                }
            }

            # Atualiza os itens da promoção
            if (isset($validatedData['promotionItems'])) {
                $promotion->promotionItems()->delete();
                foreach ($validatedData['promotionItems'] as $promotionItem) {
                    PromotionItem::query()->create([
                        'promotion_id' => $promotion->id,
                        'promotionable_type' => $promotionItem['type'],
                        'promotionable_id' => $promotionItem['id']
                    ]);
                }
            }

            # Atualiza os filtros
            if (isset($validatedData['filters'])) {
                $promotion->filters()->delete();
                foreach ($validatedData['filters'] as $filter) {
                    Filter::query()->create([
                        'promotion_id' => $promotion->id,
                        'type' => $filter['type'],
                        'name' => $filter['name']
                    ]);
                }
            }

            return response()->json(
                $promotion->load(
                    'creditPromotions',
                    'cashPromotions',
                    'cashPromotions.formPayment',
                    'promotionItems',
                    'filters'
                ), 200
            );
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação.',
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function destroy(int $id): JsonResponse {
        $promotion = $this->promotion->query()->with([
            'creditPromotions',
            'cashPromotions',
            'cashPromotions.formPayment',
            'promotionItems',
        ])->find($id);

        if (!$promotion) {
            return response()->json([
                'error' => 'A promoção informada não existe na base de dados.'
            ], 404);
        }

        try {
            $promotion->delete();
            return response()->json(null, 204);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação.',
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function deleteAll(Request $request): JsonResponse {
        $validatedData = $request->validate(
            ['id' => 'required|array', 'id.*' => 'integer|exists:promotions,id',],
            ['id.required' => 'O campo id é obrigatório.', 'id.*.integer' => 'O valor do campo id deve ser um número inteiro.', 'id.*.exists' => 'A promoção informada não existe na base de dados.',]
        );

        try {
            $this->promotion->query()->whereIn('id', $validatedData['id'])->delete();
            return response()->json(['message' => 'Registros excluídos com sucesso.']);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Error ao processar a soliciatação.',
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
