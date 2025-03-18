<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sale extends Model {

    use HasFactory;

    protected $fillable = [
        'number_ata',
        'customer_id',
        'user_id',
        'payment_method_id',
        'status',
        'total_amount',
    ];

    public function rules(): array {
        return [
            'number_ata' => 'required|string|unique:sales',
            'customer_id' => 'required|exists:customers,id',
            'user_id' => 'required|exists:users,id',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'status' => 'nullable|in:Pago,Pendente,Cancelado,Atrasado',
            'total_amount' => 'nullable|numeric',

            'items' => 'required|array',
            'items.*.type' => 'required|in:frame,service,lens',
            'items.*.id' => 'required|integer',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.total' => 'nullable|numeric',

            'items.*.promotions' => 'nullable|array',
            'items.*.promotions.*.promotion_id' => 'nullable|exists:promotions,id',
            'items.*.promotions.*.paymentable_type' => 'nullable|in:cash,credit',
            'items.*.promotions.*.paymentable_id' => 'nullable|integer',
            'items.*.promotions.*.store_credit' => 'nullable|numeric',
            'items.*.promotions.*.discount_value' => 'nullable|numeric',
            'items.*.promotions.*.discount_percentage' => 'nullable|numeric',
        ];
    }

    public function messages(): array {
        return [
            'number_ata.required' => 'O campo ATA é obrigatório.',
            'number_ata.string' => 'O campo ATA deve ser do tipo texto.',
            'number_ata.unique' => 'O número da ATA já está em uso.',

            'customer_id.required' => 'O campo cliente é obrigatório.',
            'customer_id.exists' => 'O cliente informado não existe na base de dados.',

            'user_id.required' => 'O campo vendedor é obrigatório.',
            'user_id.exists' => 'O vendedor informado não existe na base de dados.',

            'payment_method_id.required' => 'O campo método de pagamento é obrigatório.',
            'payment_method_id.exists' => 'O método de pagamento informado não existe na base de dados.',

            'status.in' => 'O status deve ser um dos seguintes valores: Pago, Pendente, Cancelado ou Atrasado.',

            'total_amount.numeric' => 'O campo valor total deve ser um número.',

            'items.required' => 'É necessário informar ao menos um item.',
            'items.array' => 'O campo itens deve ser um array.',

            'items.*.type.required' => 'O campo tipo do item é obrigatório.',
            'items.*.type.in' => 'O tipo do item deve ser "frame", "service" ou "lens".',

            'items.*.id.required' => 'O campo "ID" do item é obrigatório.',
            'items.*.id.integer' => 'O campo "ID" do item deve ser um número inteiro.',

            'items.*.quantity.required' => 'O campo "quantidade" do item é obrigatório.',
            'items.*.quantity.integer' => 'O campo "quantidade" do item deve ser um número inteiro.',
            'items.*.quantity.min' => 'A quantidade do item deve ser pelo menos 1.',

            'items.*.promotions.array' => 'O campo "promoções" deve ser um array.',
            'items.*.promotions.*.promotion_id.exists' => 'A promoção informada não existe na base de dados.',
            'items.*.promotions.*.paymentable_type.in' => 'O tipo de pagamento deve ser "cash" ou "credit".',
            'items.*.promotions.*.paymentable_id.integer' => 'O campo "ID" do método de pagamento deve ser um número inteiro.',
            'items.*.promotions.*.store_credit.numeric' => 'O crédito em loja deve ser um número.',
            'items.*.promotions.*.discount_value.numeric' => 'O valor do desconto deve ser um número.',
            'items.*.promotions.*.discount_percentage.numeric' => 'O percentual de desconto deve ser um número.',
        ];
    }

    ### Relationships ###
    public function items(): HasMany {
        return $this->hasMany(SaleItem::class);
    }

    public function customer(): BelongsTo {
        return $this->belongsTo(Customer::class);
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function paymentMethod(): BelongsTo {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function paymentCredits(): HasMany {
        return $this->hasMany(PaymentCredit::class);
    }

    public function combinedPayment(): HasMany {
        return $this->hasMany(CombinedPayment::class);
    }

    public function frames(): BelongsToMany {
        return $this->BelongsToMany(
            Frame::class,
            'sale_items',
            'sale_id',
            'sellable_id'
        )
            ->where('sellable_type', Frame::class)
            ->withPivot(
                'id',
                'quantity',
                'price',
                'total',
                'user_id'
            )
            ->withTimestamps();
    }

    public function lenses(): BelongsToMany {
        return $this->belongsToMany(
            Lens::class,
            'sale_items',
            'sale_id',
            'sellable_id',
        )
            ->where('sellable_type', Lens::class)
            ->withPivot(
                'id',
                'quantity',
                'price',
                'total',
                'user_id'
            )
            ->withTimestamps();
    }

    public function services(): BelongsToMany {
        return $this->BelongsToMany(
            Service::class,
            'sale_items',
            'sale_id',
            'sellable_id'
        )
            ->where('sellable_type', Service::class)
            ->withPivot(
                'id',
                'quantity',
                'price',
                'total',
                'user_id'
            )
            ->withTimestamps();
    }

    public function cashPromotions(): BelongsToMany {
        return $this->belongsToMany(
            CashPromotion::class,
            'sale_items',
            'sale_id',
            'paymentable_id'
        )
            ->where('paymentable_type', CashPromotion::class)
            ->withPivot('store_credit', 'discount_value', 'discount_percentage')
            ->withTimestamps();
    }

    public function creditPromotions(): BelongsToMany {
        return $this->belongsToMany(
            CreditPromotion::class,
            'sale_items',
            'sale_id',
            'paymentable_id'
        )
            ->where('paymentable_type', CreditPromotion::class)
            ->withPivot('store_credit', 'discount_value', 'discount_percentage')
            ->withTimestamps();
    }

    public function creditCards(): HasMany {
        return $this->hasMany(CreditCard::class, 'sale_id');
    }

    public function serviceOrder(): HasMany {
        return $this->hasMany(ServiceOrder::class);
    }
}
