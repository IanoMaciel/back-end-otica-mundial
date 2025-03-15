<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class SaleItem extends Model {
    use HasFactory;

    protected $fillable = [
        'sale_id',
        'sellable_type',
        'sellable_id',
        'quantity',
        'price',

        'promotion_id',
        'form_paymentable_type',
        'form_paymentable_id',
        'store_credit',
        'discount_value',
        'discount_percentage',
        'final_price'
    ];

    public function sellable(): MorphTo {
        return $this->morphTo();
    }

    public function paymentable(): MorphTo {
        return $this->morphTo();
    }

    public function sale(): BelongsTo {
        return$this->belongsTo(Sale::class, 'sale_id');
    }
}
