<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CreditCard extends Model {
    use HasFactory;

    protected $fillable = [
        'sale_id',
        'card_id',
        'discount',
        'total_amount',
    ];

    public function rules(bool $update=false): array {
        return [
            'sale_id' => 'required|exists:sales,id',
            'card_id' => 'required|exists:cards,id',
            'discount' => 'nullable|numeric',
            'total_amount' => 'nullable|numeric',
        ];
    }

    public function messages(): array {
        return [
            'sale_id.required' => 'O campo ID da venda é obrigatório.',
            'sale_id.exists' => 'A venda informada não existe na base de dados.',

            'card_id.required' => 'O campo ID do número de parcelas é obrigatório.',
            'card_id.exists' => 'A número de parcela informado não existe na base de dados.',

            'discount.numeric' => 'O campo desconto deve ser numérico.',

            'total_amount.numeric' => 'O campo valor total deve ser numérico.'
        ];
    }

    # Relationships
    public function sale(): BelongsTo {
        return $this->belongsTo(Sale::class);
    }

    public function card(): BelongsTo {
        return $this->belongsTo(Card::class, 'card_id');
    }
}
