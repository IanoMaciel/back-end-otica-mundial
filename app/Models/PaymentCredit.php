<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaymentCredit extends Model {
    use HasFactory;

    protected $fillable = [
        'sale_id',
        'form_payment_id',
        'card_id',
        'total_amount',
        'down_payment',
    ];

    public function rules(): array {
        return [
            'sale_id' => 'required|exists:sales,id',
            'form_payment_id' => 'required|exists:form_payments,id',
            'card_id' => 'nullable|exists:cards,id',
            'total_amount' => 'nullable|numeric',
            'down_payment' => 'nullable|numeric',

            'installments' => 'required|array',
            'installments.*.payment_credit_id' => 'nullable|exists:payment_credits,id',
            'installments.*.form_payment_id' => 'nullable|exists:form_payments,id',
            'installments.*.card_id' => 'exists:cards,id',
            'installments.*.due_date' => 'required|date',
            'installments.*.status' => 'nullable|string|in:Pendente,Pago,Atrasado',
            'installments.*.amount' => 'required|numeric',
            'installments.*.installment' => 'nullable|numeric',
        ];
    }

    public function messages(): array {
        return [
            'sale_id.required' => 'O campo ID da venda é obrigatório.',
            'sale_id.exists' => 'O ID da venda não existe.',
            'form_payment_id.required' => 'O campo forma de pagamento é obrigatório.',
            'form_payment_id.exists' => 'O campo forma de pagamento não existe.',
            'card_id.exists' => 'O ID do cartão não existe.',
            'total_amount.numeric' => 'O total da venda deve ser numérico.',
            'down_payment.numeric' => 'O campo entrada deve ser numérico.',

            'installments.required' => 'As parcelas são obrigatórias.',
            'installments.array' => 'As parcelas devem ser um array.',
            'installments.*.payment_credit_id.required' => 'O ID do crédito de pagamento é obrigatório.',
            'installments.*.payment_credit_id.exists' => 'O ID do crédito de pagamento não existe.',
            'installments.*.form_payment_id.required' => 'O ID da forma de pagamento é obrigatório.',
            'installments.*.form_payment_id.exists' => 'O ID da forma de pagamento não existe.',
            'installments.*.card_id.required' => 'O ID do cartão é obrigatório.',
            'installments.*.card_id.exists' => 'O ID do cartão não existe.',
            'installments.*.due_date.required' => 'A data de vencimento é obrigatória.',
            'installments.*.due_date.date' => 'A data de vencimento deve ser uma data válida.',
            'installments.*.status.required' => 'O status é obrigatório.',
            'installments.*.status.string' => 'O status deve ser uma string.',
            'installments.*.status.in' => 'O status deve ser um dos seguintes valores: Pendente, Pago, Atrasado.',
            'installments.*.amount.required' => 'O valor é obrigatório.',
            'installments.*.amount.numeric' => 'O valor deve ser numérico.',
            'installments.*.installment.numeric' => 'O campo parcela deve ser um número válido.',
        ];
    }


    public function sale(): BelongsTo {
        return $this->belongsTo(Sale::class);
    }

    public function installments(): HasMany {
        return $this->hasMany(Installment::class);
    }
}
