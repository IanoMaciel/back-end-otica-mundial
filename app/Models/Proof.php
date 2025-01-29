<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Proof extends Model {
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'expense_id',
        'proof',
    ];

    public function expense(): BelongsTo {
        return $this->belongsTo(Expense::class);
    }
}
