<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accessory extends Model {
    use HasFactory;

    protected $fillable = [
        'name',
        'barcode',
        'amount',
        'price',
    ];

    public function rules(bool $update = false): array {
        return [
            'name' => $update ? 'sometimes|string' : 'required|string|unique:accessories',
            'barcode' => 'sometimes|string|unique:accessories',
            'amount' => 'sometimes|numeric',
            'price' => $update ? 'sometimes|numeric' : 'required|numeric',
        ];
    }

    public function messages(): array {
        return [
            'name.required' => 'O campo nome é obrigatório.',
            'name.string' => 'O campo nome deve ser uma string.',
            'name.unique' => 'O campo nome deve ser único.',

            'barcode.string' => 'O código de barras deve ser uma string.',
            'amount.numeric' => 'A quantidade deve ser um valor numérico.',

            'price.required' => 'O campo preço é obrigatório.',
            'price.numeric' => 'O campo preço deve ser um valor numérico.',
        ];
    }

}
