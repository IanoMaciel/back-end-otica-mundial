<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AboutLens extends Model {
    use HasFactory;
    protected $fillable = [
        'stock_lens_id',
        'spherical',
        'cylindrical',
        'quantity'
    ];

    public function stockLens(): BelongsTo {
        return $this->belongsTo(StockLens::class);
    }
}
