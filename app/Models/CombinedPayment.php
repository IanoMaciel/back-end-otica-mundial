<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CombinedPayment extends Model {
    use HasFactory;
    protected $fillable = [
        'sale_id',
        'form_payment_id',
        'card_id',
        'discount',
        'total_amount',
    ];

    public function rules(): array {
        return [
            'sale_id' => 'required|exists:sales,id',
            'form_payment_id' => 'required|exists:combined_payments,id',
            'card_id' => 'required|exists:cards,id',
            'discount' => 'nullable|numeric',
            'total_amount' => 'nullable|numeric',
        ];
    }
}
