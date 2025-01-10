<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Sale extends Model {

    use HasFactory;

    protected $fillable = [
        'number_ata',
        'customer_id',
        'user_id',
        'payment_method_id',
        'status',
        'discount_frame',
        'total_amount',
    ];

    public function rules(): array {
        return [
            'number_ata' => 'required|string',
            'customer_id' => 'required|exists:customers,id',
            'user_id' => 'required|exists:users,id',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'status' => 'nullable|in:Pago,Pendente,Cancelado,Atrasado',
            'discount_frame' => 'nullable|numeric',
            'discount_lens' => 'nullable|numeric',
            'total_amount' => 'nullable|numeric',
            'items' => 'required|array',
            'items.*.type' => 'required|in:frame,service',
            'items.*.id' => 'required|integer',
            'items.*.quantity' => 'required|integer|min:1'
        ];
    }

    public function messages(): array {
        return [
            'number_ata.required' => 'O campo ATA é obrigatório.',
            'number_ata.string' => 'O campo ATA deve ser do tipo texto.',

            'customer_id.required' => 'O campo cliente é obrigatório.',
            'customer_id.exists' => 'O cliente informado não existe na base de dados.',

            'user_id.required' => 'O campo vendedor é obrigatório.',
            'user_id.exists' => 'O vendedor informado não existe na base de dados.',

            'payment_method_id.required' => 'O campo método de pagamento é obrigatório.',
            'payment_method_id.exists' => 'O método de pagamento informado não existe na base de dados.',

            'status.in' => 'O status deve ser um dos seguintes: Pago, Pendente, Cancelado ou Atrasado.',

            'discount_frame.numeric' => 'O campo desconto deve ser numérico.',
            'discount_lens.numeric' => 'O campo desconto deve ser numérico.',

            'total_amount.numeric' => 'O campo valor total deve ser numérico.',

            'items.required' => 'É necessário informar ao menos um item.',
            'items.array' => 'O campo itens deve ser um array.',

            'items.*.type.required' => 'O campo tipo do item é obrigatório.',
            'items.*.type.in' => 'O tipo do item deve ser "frame" ou "service".',

            'items.*.id.required' => 'O campo "ID" do item é obrigatório.',
            'items.*.id.integer' => 'O campo "ID" do item deve ser um número inteiro.',

            'items.*.quantity.required' => 'O campo "quantidade" do item é obrigatório.',
            'items.*.quantity.integer' => 'O campo "quantidade" do item deve ser um número inteiro.',
            'items.*.quantity.min' => 'A quantidade do item deve ser pelo menos 1.',
        ];
    }

    # Relationships
    public function items(): HasMany
    {
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

    public function frames(): BelongsToMany {
        return $this->BelongsToMany(
            Frame::class,
            'sale_items',
            'sale_id',
            'sellable_id'
        )
            ->where('sellable_type', Frame::class)
            ->withPivot('quantity', 'price')
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
            ->withPivot('quantity', 'price')
            ->withTimestamps();
    }
}
