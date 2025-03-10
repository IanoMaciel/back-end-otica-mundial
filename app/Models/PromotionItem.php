<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class PromotionItem extends Model {
    use HasFactory;
    protected $fillable = [
        'promotion_id',
        'promotionable_type',
        'promotionable_id',
    ];

    # Relationships
    public function promotion(): BelongsTo {
        return $this->belongsTo(Promotion::class);
    }

    public function promotionable(): MorphTo {
        return $this->morphTo();
    }
}
