<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CombinedPayment extends Model {
    use HasFactory;
    protected $fillable = [
        'sale_id',
        'total_amount',
    ];

    public function rules(): array {
        return [
            'sale_id' => 'required|exists:sales,id',
            'total_amount' => 'nullable|numeric',
            'discount' => 'nullable|numeric',

            'portions' => 'required|array',
            'portions.*.form_payment_id' => 'required|exists:form_payments,id',
            'portions.*.card_id' => 'nullable|exists:cards,id',
            'portions.*.amount' => 'required|numeric'
        ];
    }

    public function messages(): array {
        return [
            'sale_id.required' => 'O campo venda é obrigatório.',
            'sale_id.exists' => 'A venda informada não existe na base de dados.',
            'total_amount.numeric' => 'O campo valor total deve ser um número.',
            'discount.numeric' => 'O campo discount deve ser um número.',

            'portions.required' => 'O campo porções é obrigatório.',
            'portions.array' => 'O campo porções deve ser um array.',
            'portions.*.form_payment_id.required' => 'O campo forma de pagamento é obrigatório para cada porção.',
            'portions.*.form_payment_id.exists' => 'A forma de pagamento informada não existe na base de dados para uma das porções.',
            'portions.*.card_id.exists' => 'O número de parcelas informado não existe na base de dados para uma das porções.',
            'portions.*.amount.required' => 'O campo valor é obrigatório para cada porção.',
            'portions.*.amount.numeric' => 'O campo valor deve ser um número para cada porção.',
        ];
    }


    # Relationships
    public function portions(): HasMany {
        return $this->hasMany(PaymentPortion::class);
    }

    public function sale(): BelongsTo {
        return $this->belongsTo(Sale::class);
    }
}
