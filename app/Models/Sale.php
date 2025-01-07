<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Sale extends Model {

    use HasFactory;

    protected $fillable = [
        'customer_id',
        'user_id',
        'payment_method_id',
        'status',
        'discount',
        'total_amount',
    ];

    # Relationships
    public function customer(): BelongsTo {
        return $this->belongsTo(Customer::class);
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function paymentMethod(): BelongsTo {
        return $this->belongsTo(BelongsTo::class);
    }

    public function frames(): BelongsToMany {
        return $this->BelongsToMany(Frame::class, 'sale_items')
            ->withPivot('quantity', 'price')
            ->withTimestamps();
    }

    public function services(): BelongsToMany {
        return $this->BelongsToMany(Frame::class, 'sale_items')
            ->withPivot('quantity', 'price')
            ->withTimestamps();
    }
}
