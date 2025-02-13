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
        'discount',
        'total',
        'discount_id'
    ];

    public function sellable(): MorphTo {
        return $this->morphTo();
    }

    public function sale(): BelongsTo {
        return$this->belongsTo(Sale::class);
    }

    public function discount(): BelongsTo {
        return $this->belongsTo(Discount::class, 'discount_id');
    }
}
