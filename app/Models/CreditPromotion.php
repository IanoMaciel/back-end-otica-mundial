<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CreditPromotion extends Model {
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'promotion_id',
        'installment',
        'discount',
    ];

    # relationships
    public function promotion(): BelongsTo {
        return $this->belongsTo(Promotion::class);
    }
}
