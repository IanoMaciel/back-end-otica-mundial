<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Installment extends Model {
    use HasFactory;

    protected $fillable = [
        'payment_credit_id',
        'form_payment_id',
        'card_id',
        'due_date',
        'status',
        'amount',
    ];

    public function rules(): array {
        return [
            'payment_credit_id' => 'nullable|exists:payment_credits,id',
            'form_payment_id' => 'nullable|exists:form_payments,id',
            'card_id' => 'nullable|exists:cards,id',
            'due_date' => 'nullable|date',
            'status' => 'nullable|string|in:Pendente,Pago,Atrasado',
            'amount' => 'nullable|numeric',
        ];
    }

    public function messages(): array {
        return [
            'payment_credit_id.exists' => 'O ID do pagamento não existe.',
            'form_payment_id.exists' => 'O ID da forma de pagamento não existe.',
            'card_id.exists' => 'O ID do cartão não existe.',
            'due_date.date' => 'A data de vencimento deve ser uma data válida.',
            'status.in' => 'O status deve ser um dos seguintes: Pendente, Pago, Atrasado.',
            'amount.numeric' => 'O valor deve ser um número válido.',
        ];
    }

    # Relationships
    public function paymentCredit(): BelongsTo {
        return $this->belongsTo(PaymentCredit::class);
    }

    public function formPayment(): BelongsTo {
        return $this->belongsTo(FormPayment::class);
    }

    public function card(): BelongsTo {
        return $this->belongsTo(Card::class);
    }
}
