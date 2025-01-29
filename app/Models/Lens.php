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
        'index',
        'treatment_id',
        'filter',
        'sensitivity_id',
        'name_lens',
        'spherical',
        'cylindrical',
        'laboratory_id',
        'minimum_value',
        'discount',
        'price',
        'delivery',
    ];

    # Validations
    public function rules(bool $update = false): array {
        return [
            'barcode' => $update ? 'nullable|string' : 'nullable|string|unique:lenses',
            'type_lens_id' => 'required|exists:type_lenses,id',
            'index' => 'required|numeric',
            'treatment_id' => 'required|exists:treatments,id',
            'filter' => 'required|boolean',
            'sensitivity_id' => 'required|exists:sensitivities,id',
            'name_lens' => 'required|string',
            'spherical' => 'required|numeric',
            'cylindrical' => 'required|numeric',
            'laboratory_id' => 'required|exists:laboratories,id',
            'minimum_value' => 'nullable|numeric',
            'discount' => 'nullable|numeric',
            'price' => 'required|numeric',
            'delivery' => 'required|integer',
        ];
    }

    public function messages(): array {
        return [
            'barcode.string' => 'O código de barras deve ser texto.',
            'barcode.unique' => 'O código de barras deve ser único.',

            'type_lens_id.required' => 'O tipo de lente é obrigatório.',
            'type_lens_id.exists' => 'O tipo de lente informado não existe.',

            'index.required' => 'O índice é obrigatório.',
            'index.numeric' => 'O índice deve ser um número.',

            'treatment_id.required' => 'O tratamento é obrigatório.',
            'treatment_id.exists' => 'O tratamento informado não existe.',

            'filter.required' => 'O filtro é obrigatório.',
            'filter.boolean' => 'O filtro deve ser verdadeiro ou falso.',

            'sensitivity_id.required' => 'A sensibilidade é obrigatória.',
            'sensitivity_id.exists' => 'A sensibilidade informada não existe.',

            'name_lens.required' => 'O nome da lente é obrigatório.',
            'name_lens.string' => 'O nome da lente deve ser texto.',

            'spherical.required' => 'O grau esférico é obrigatório.',
            'spherical.numeric' => 'O grau esférico deve ser um número.',

            'cylindrical.required' => 'O grau cilíndrico é obrigatório.',
            'cylindrical.numeric' => 'O grau cilíndrico deve ser um número.',

            'laboratory_id.required' => 'O laboratório é obrigatório.',
            'laboratory_id.exists' => 'O laboratório informado não existe.',

            'minimum_value.numeric' => 'O valor mínimo deve ser um número.',

            'discount.numeric' => 'O desconto deve ser um número.',

            'price.required' => 'O preço é obrigatório.',
            'price.numeric' => 'O preço deve ser um número.',

            'delivery.required' => 'O prazo de entrega é obrigatório.',
            'delivery.integer' => 'O prazo de entrega deve ser um número inteiro.',
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

    public function laboratory(): BelongsTo {
        return $this->belongsTo(Laboratory::class);
    }
}
