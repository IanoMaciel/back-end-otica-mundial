<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StockLens extends Model {
    use HasFactory;
    protected $fillable = [
        'name_lens',
        'spherical_start',
        'spherical_end',
        'cylindrical_start',
        'cylindrical_end'
    ];

    public function aboutLens(): HasMany {
        return $this->hasMany(AboutLens::class);
    }
}
