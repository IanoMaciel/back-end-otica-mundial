<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CashPromotion extends Model {
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'promotion_id',
        'form_payment_id',
        'discount',
    ];

    # relationships
    public function promotion(): BelongsTo {
        return $this->belongsTo(Promotion::class);
    }

    public function formPayment(): BelongsTo {
        return $this->belongsTo(FormPayment::class);
    }
}
