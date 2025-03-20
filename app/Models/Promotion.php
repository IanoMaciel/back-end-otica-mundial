<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Promotion extends Model {
    use HasFactory;
    protected $fillable = [
        'title',
        'start',
        'end',
        'status',
        'auth',
        'store_credit_discount',
    ];

    public function rules(bool $update = false): array {
        return [
            'title' => $update ? 'nullable|string|max:30' : 'required|string|max:50',
            'start' => $update ? 'nullable|date' : 'required|date',
            'end' => $update ? 'nullable|date|after:start' : 'required|date|after:start',
            'status' => 'nullable|in:Ativa,Inativa,Agendada',
            'auth' => $update ? 'nullable|in:Administrador,Gerente,Loja' : 'required|in:Administrador,Gerente,Loja',
            'store_credit_discount' => 'nullable|numeric',

            'creditPromotions' => 'required|array',
            'creditPromotions.*.promotion_id' => 'nullable|exists:promotions,id',
            'creditPromotions.*.installment' => 'nullable|numeric',
            'creditPromotions.*.discount' => 'nullable|numeric',

            'cashPromotions' => 'required|array',
            'cashPromotions.*.promotion_id' => 'nullable|exists:promotions,id',
            'cashPromotions.*.form_payment_id' => 'nullable|exists:form_payments,id',
            'cashPromotions.*.discount' => 'nullable|numeric',

            'promotionItems' => 'required|array',
            'promotionItems.*.promotion_id' => 'nullable|exists:promotion,id',
            'promotionItems.*.type' => 'nullable|in:lens,frame',
            'promotionItems.*.id' => 'nullable|integer',

            'filters' => 'nullable|array',
            'filters.*.promotion_id' => 'nullable|exists:promotion,id',
            'filters.*.type' => 'nullable|string',
            'filters.*.name' => 'nullable|string',
        ];
    }

    public function messages(): array {
        return [
            'title.required' => 'O campo Título é obrigatório.',
            'title.string' => 'O campo Título deve ser do tipo texto.',
            'title.max' => 'O campo Título não pode ter mais de 50 caracteres.',

            'start.required' => 'O campo Data de Início é obrigatório.',
            'start.date' => 'O campo Data de Início deve ser do tipo Date.',

            'end.required' => 'O campo Data de Término é obrigatório.',
            'end.date' => 'O campo Data de Término deve ser do tipo Date.',
            'end.after' => 'O campo Data de Término deve ser posterior à Data de Início.',

            'status.in' => 'O campo Status deve ser um dos valores: Ativa, Inativa, Agendada',

            'auth.required' => 'O campo Nível de Autorização é obrigatório.',
            'auth.in' => 'O campo Nível de Autorização deve ser um dos valores: Administrador, Gerente, Loja',

            'store_credit_discount.numeric' => 'O campo Desconto no Crédito da Loja deve ser um número.',

            'creditPromotions.required' => 'As promoções de crédito são obrigatórias.',
            'creditPromotions.array' => 'As promoções de crédito devem ser um array.',
            'creditPromotions.*.promotion_id.exists' => 'A promoção de crédito informada não existe.',
            'creditPromotions.*.installment.numeric' => 'O número de parcelas para a promoção de crédito deve ser um número.',
            'creditPromotions.*.discount.numeric' => 'O desconto da promoção no crédito deve ser um número.',

            'cashPromotions.required' => 'As promoções à vista são obrigatórias.',
            'cashPromotions.array' => 'As promoções à vista devem ser um array.',
            'cashPromotions.*.promotion_id.exists' => 'A promoção à vista informada não existe.',
            'cashPromotions.*.form_payment_id.exists' => 'A forma de pagamento da promoção à vista informada não existe.',
            'cashPromotions.*.discount.numeric' => 'O desconto da promoção à vista deve ser um número.',

            'promotionItems.required' => 'Os itens da promoção são obrigatórios.',
            'promotionItems.array' => 'Os itens da promoção devem ser um array.',
            'promotionItems.*.promotion_id.exists' => 'O item da promoção informado não existe.',
            'promotionItems.*.type.in' => 'O tipo do item da promoção deve ser um dos valores: lens, frame.',

            'filters.array' => 'Os filtros devem ser um array',
            'filters.*.promotion_id.exists' => 'A promoção à vista informada não existe.',
            'filters.*.type.string' => 'O tipo deve ser do tipo texto',
            'filters.*.name.string' => 'O nome deve ser do tipo texto',
        ];
    }

    # Relationships
    public function creditPromotions(): HasMany {
        return $this->hasMany(CreditPromotion::class);
    }

    public function cashPromotions(): HasMany {
        return $this->hasMany(CashPromotion::class);
    }

    public function promotionItems(): HasMany {
        return $this->hasMany(PromotionItem::class);
    }

    public function filters(): HasMany {
        return $this->hasMany(Filter::class);
    }

    public function saleItems(): HasMany {
        return $this->hasMany(SaleItem::class);
    }
}
