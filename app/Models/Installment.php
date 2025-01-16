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
