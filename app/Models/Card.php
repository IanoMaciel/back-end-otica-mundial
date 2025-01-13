<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\JsonResponse;

class Card extends Model {
    use HasFactory;

    protected $fillable = [
        'number_installment', // número de parcelas
        'interest_rate', // taxa de juros
    ];

    public function rules(bool $update=false): array {
        return [
            'number_installment' => $update ? 'nullable|numeric|' : 'required|numeric|unique:cards',
            'interest_rate' => $update ? 'nullable|numeric' : 'required|numeric',
        ];
    }

    public function messages(): array {
        return [
            'number_installment.required' => 'O campo número de parcelas é obrigatório.',
            'number_installment.numeric' => 'O campo número de parcelas deve ser númerico.',
            'number_installment.unique' => 'O campo número de parcelas já existe na base de dados.',

            'interest_rate.required' => 'O campo taxa é obrigatório.',
            'interest_rate.numeric' => 'O campo taxa deve ser númerico.',
        ];
    }

    # Relationships
    public function creditCards(): HasMany {
        return $this->hasMany(CreditCard::class);
    }
}
