<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Address extends Model {
    use HasFactory;
    protected $fillable = [
        'customer_id',
        'cep',
        'uf',
        'city',
        'street',
        'number',
        'neighborhood',
        'complement',
        'reference',
    ];

    public function rules(): array {
        return [
            'customer_id' => 'required|exists:customers,id',
            'cep' => 'nullable|string|formato_cep',
            'uf' => 'nullable|string|uf',
            'city' => 'nullable|string',
            'street' => 'nullable|string',
            'number' => 'nullable|string',
            'neighborhood' => 'nullable|string',
            'complement' => 'nullable|string',
            'reference' => 'nullable|string',
        ];
    }

    public function messages(): array {
        return [
            'customer_id.required' => 'O campo Cliente é obrigatório.',
            'customer_id.exists' => 'O Cliente informado não existe na base de dados.',

            'cep.string' => 'O campo CEP deve ser do tipo texto.',
            'cep.formato_cep' => 'O campo CEP deve estar no seguinte formato: xxxxx-xxx ou xx.xxx-xxx',

            'uf.string' => 'O campo UF deve ser do tipo texto.',
            'uf.uf' => 'O campo UF não é uma sigla válida.',

            'city.string' => 'O campo Cidade deve ser do tipo texto.',
            'street.string' => 'O campo Rua deve ser do tipo texto.',
            'number.string' => 'O campo Número deve ser do tipo texto.',
            'neighborhood.string' => 'O campo Bairro deve ser do tipo texto.',
            'complement.string' => 'O campo Complemento deve ser do tipo texto.',
            'reference.string' => 'O campo Referência deve ser do tipo texto.',
        ];
    }

    # Relationships
    public function customer(): BelongsTo {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}
