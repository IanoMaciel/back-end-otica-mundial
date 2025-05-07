<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Lens extends Model {
    use HasFactory;
    protected $fillable = [
        'barcode',
        'type_lens_id',
        'index',
        'treatment_id',
        'surfacing', // new column of type boolean
        'filter',
        'sensitivity_id',
        'name_lens',
        'laboratory_id',
        'minimum_value',
        'discount',
        'price',
        'cost', // new colum of type decimal
        'delivery',
        'spherical_start',
        'spherical_end',
        'cylindrical_start',
        'cylindrical_end',
        'addition_start',
        'addition_end',
        'diameter', // new colum of type decimal
        'height', // new colum of type decimal
    ];

    # Validations
    public function rules(bool $update = false): array {
        return [
            'barcode' => $update ? 'nullable|string' : 'nullable|string|unique:lenses',
            'type_lens_id' => $update ? 'nullable|exists:type_lenses,id' : 'required|exists:type_lenses,id',
            'surfacing' => 'nullable|boolean',
            'index' => $update ? 'nullable|numeric' : 'required|numeric',
            'treatment_id' => $update ? 'nullable|exists:treatments,id' : 'required|exists:treatments,id',
            'filter' => $update ? 'nullable|boolean' : 'required|boolean',
            'sensitivity_id' => $update ? 'nullable|exists:sensitivities,id' : 'required|exists:sensitivities,id',
            'name_lens' => $update ? 'nullable|string' : 'required|string',
            'laboratory_id' => $update ? 'nullable|exists:laboratories,id' : 'required|exists:laboratories,id',
            'minimum_value' => 'nullable|numeric',
            'discount' => 'nullable|numeric',
            'price' => $update ? 'nullable|numeric' : 'required|numeric',
            'cost' => 'nullable|numeric',
            'delivery' => $update ? 'nullable|numeric' : 'required|numeric',
            'spherical_start' => $update ? 'nullable|numeric' : 'required|numeric',
            'spherical_end' => $update ? 'nullable|numeric' : 'required|numeric',
            'cylindrical_start' => 'nullable|numeric',
            'cylindrical_end' => 'nullable|numeric',
            'addition_start' => 'nullable|numeric',
            'addition_end' => 'nullable|numeric',
            'diameter' => 'nullable|numeric',
            'height' => 'nullable|string',
        ];
    }

    public function messages(): array {
        return [
            'barcode.string' => 'O código de barras deve ser texto.',
            'barcode.unique' => 'O código de barras deve ser único.',

            'type_lens_id.required' => 'O tipo de lente é obrigatório.',
            'type_lens_id.exists' => 'O tipo de lente informado não existe.',

            'surfacing.boolean' => 'O campo sufarçagem é do tipo booleano.',

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

            'spherical_start.required' => 'O grau esférico inicial é obrigatório.',
            'spherical_start.numeric' => 'O grau esférico inicial deve ser um número.',
            'spherical_end.required' => 'O grau esférico final é obrigatório.',
            'spherical_end.numeric' => 'O grau esférico final deve ser um número.',

            'cylindrical_start.numeric' => 'O grau cilíndrico inicial deve ser um número.',
            'cylindrical_end.numeric' => 'O grau cilíndrico final deve ser um número.',

            'addition_start.numeric' => 'A adição inicial deve ser um número',
            'addition_end.numeric' => 'A adição final deve ser um número.',

            'laboratory_id.required' => 'O laboratório é obrigatório.',
            'laboratory_id.exists' => 'O laboratório informado não existe.',

            'minimum_value.numeric' => 'O valor mínimo deve ser um número.',

            'discount.numeric' => 'O desconto deve ser um número.',

            'price.required' => 'O preço é obrigatório.',
            'price.numeric' => 'O preço deve ser um número.',

            'cost.numeric' => 'O custo deve ser um número.',

            'delivery.required' => 'O prazo de entrega é obrigatório.',
            'delivery.integer' => 'O prazo de entrega deve ser um número inteiro.',

            'diameter.numeric' => 'O diâmetro deve ser um número ',
            'height.string' => 'A altura deve ser do tipo texto',
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

    public function promotionItems(): MorphMany {
        return $this->morphMany(PromotionItem::class, 'promotionable');
    }

    public function singleVision(): HasMany {
        return $this->hasMany(SingleVision::class);
    }

    public function multifocalLens(): HasMany {
        return $this->hasMany(MultifocalLens::class);
    }
}
