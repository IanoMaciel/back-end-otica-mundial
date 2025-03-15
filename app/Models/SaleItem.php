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
        'total',

        'promotion_id',
        'paymentable_type',
        'paymentable_id',
        'store_credit',
        'discount_value',
        'discount_percentage',
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

    public function promotion(): BelongsTo {
        return $this->belongsTo(Promotion::class, 'promotion_id');
    }
}
