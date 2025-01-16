<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentCredit extends Model {
    use HasFactory;

    protected $fillable = [
        'sale_id',
        'down_payment',
        'discount',
        'total_amount'
    ];

    public function rules(): array {
        return [
            'sale_id' => 'required|exists:sales,id',
            'down_payment' => 'nullable|numeric',
            'discount' => 'nullable|numeric',
            'total_amount' => 'nullable|numeric',
        ];
    }

    public function messages(): array {
        return [];
    }
}
