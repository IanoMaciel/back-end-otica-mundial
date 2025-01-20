<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lens extends Model {
    use HasFactory;
    protected $fillable = [
        'barcode',
        'type_lens_id',
        'treatment_id',
        'sensitivity_id',
        'filter',
        'name_lens',
        'spherical',
        'cylindrical',
        'purchase_value',
        'profit',
        'discount',
        'price',
    ];

    # Validations
    public function rules(): array {
        return [
            'barcode' => 'nullable|string|unique:lenses',
            'type_lens_id' => 'required|exists:type_lenses,id',
            'treatment_id' => 'required|exists:treatments,id',
            'sensitivity_id' => 'required|exists:sensitivities,id',
            'filter' => 'required|boolean',
            'name_lens' => 'required|string',
            'spherical' => 'required|numeric',
            'cylindrical' => 'required|numeric',
            'purchase_value' => 'nullable|numeric',
            'profit' => 'nullable|numeric',
            'discount' => 'nullable|numeric',
            'price' => 'required|numeric',
        ];
    }

    public function messages(): array {
        return [
            'barcode.required' => 'O código de barras é obrigatório.',
            'barcode.unique' => 'O código de barras deve ser único.',

            'type_lens_id.required' => 'O tipo de lente é obrigatório.',
            'type_lens_id.exists' => 'O tipo de lente deve ser válido.',

            'treatment_id.required' => 'O tratamento é obrigatório.',
            'treatment_id.exists' => 'O tratamento deve ser válido.',

            'sensitivity_id.required' => 'A sensibilidade é obrigatória.',
            'sensitivity_id.exists' => 'A sensibilidade deve ser válida.',

            'filter.required' => 'O filtro é obrigatório.',
            'filter.boolean' => 'O filtro deve ser verdadeiro ou falso.',

            'name_lens.required' => 'O nome da lente é obrigatório.',

            'spherical.required' => 'O campo esférico é obrigatório.',
            'spherical.numeric' => 'O campo esférico deve ser numérico.',
            'cylindrical.required' => 'O campo cilíndrico é obrigatório.',
            'cylindrical.numeric' => 'O campo cilíndrico deve ser numérico.',

            'purchase_value.numeric' => 'O valor da compra deve ser numérico.',
            'profit.numeric' => 'O lucro deve ser numérico.',
            'discount.numeric' => 'O desconto deve ser numérico.',

            'price.required' => 'O preço é obrigatório.',
            'price.numeric' => 'O preço deve ser numérico.',
        ];
    }

    # Relationships
    public function typeLens(): BelongsTo {
        return $this->belongsTo(TypeLens::class);
    }

    public function treatment(): BelongsTo {
        return $this->belongsTo(Treatment::class);
    }

    public function sensitivity(): BelongsTo {
        return $this->belongsTo(Sensitivity::class);
    }
}
