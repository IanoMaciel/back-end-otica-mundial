<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentPortion extends Model {
    use HasFactory;

    protected $fillable = [
        'combined_payment_id',
        'form_payment_id',
        'card_id',
        'amount'
    ];

    public function combinedPayment(): BelongsTo {
        return $this->belongsTo(CombinedPayment::class);
    }

    public function formPayment(): BelongsTo {
        return $this->belongsTo(FormPayment::class);
    }

    public function card(): BelongsTo {
        return $this->belongsTo(Card::class);
    }
}
