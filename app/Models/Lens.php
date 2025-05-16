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
        'index_id', // new column
        'surfacing_id', // new column
        'treatment_id',
        'filter',
        'sensitivity_id',
        'name_lens',
        'laboratory_lens_id', // new column
        'laboratory_id', // new column
        'delivery',
        'spherical_start',
        'spherical_end',
        'cylindrical_start',
        'cylindrical_end',
        'addition_start',
        'addition_end',
        'diameter_id', // new column
        'height_id', // new column
        'cost', // new column
        'minimum_value',
        'discount',
        'price',
        'profit', // new column
    ];

    # Validations
    public function rules(bool $update = false): array {
        return [
            'barcode' => $update ? 'nullable|string' : 'nullable|string|unique:lenses',
            'type_lens_id' => $update ? 'nullable|exists:type_lenses,id' : 'required|exists:type_lenses,id',

            'index_id' => $update ? 'nullable|exists:indices,id' : 'required|exists:indices,id', //alterado de 'index' para 'index_id' (new column)
            'surfacing_id' => $update ? 'nullable|exists:surfacings,id' : 'required|exists:surfacings,id', //alterado de 'surfacing' para 'surfacing_id' (new column)

            'treatment_id' => $update ? 'nullable|exists:treatments,id' : 'required|exists:treatments,id',
            'filter' => $update ? 'nullable|boolean' : 'required|boolean',
            'sensitivity_id' => $update ? 'nullable|exists:sensitivities,id' : 'required|exists:sensitivities,id',
            'name_lens' => $update ? 'nullable|string' : 'required|string',

            'laboratory_lens_id' => $update ? 'nullable|exists:laboratories,id' : 'required|exists:laboratories,id', // novo campo adicionado
            'laboratory_id' => $update ? 'nullable|exists:laboratories,id' : 'required|exists:laboratories,id',

            'delivery' => $update ? 'nullable|numeric' : 'required|numeric',

            'spherical_start' => $update ? 'nullable|numeric' : 'required|numeric',
            'spherical_end' => $update ? 'nullable|numeric' : 'required|numeric',
            'cylindrical_start' => 'nullable|numeric',
            'cylindrical_end' => 'nullable|numeric',
            'addition_start' => 'nullable|numeric',
            'addition_end' => 'nullable|numeric',

            'diameter_id' => $update ? 'nullable|exists:diameters,id' : 'required|exists:diameters,id', // alterado de 'diameter' para 'diameter_id' (new column)
            'height_id' => $update ? 'nullable|exists:heights,id' : 'required|exists:heights,id', // alterado de 'height' para 'height_id' (new column)

            'cost' => 'nullable|numeric', // novo campo adicionado
            'minimum_value' => 'nullable|numeric',
            'discount' => 'nullable|numeric',
            'price' => $update ? 'nullable|numeric' : 'required|numeric',
            'profit' => 'nullable|numeric', // novo campo adicionado
        ];
    }

    public function messages(): array {
        return [
            'barcode.string' => 'O código de barras deve ser texto.',
            'barcode.unique' => 'O código de barras deve ser único.',

            'type_lens_id.required' => 'O tipo de lente é obrigatório.',
            'type_lens_id.exists' => 'O tipo de lente informado não existe.',

            'index_id.required' => 'O índice é obrigatório.',
            'index_id.exists' => 'O índice informado não existe.',

            'surfacing_id.required' => 'O tipo de surfacagem é obrigatório.',
            'surfacing_id.exists' => 'O tipo de surfacagem informado não existe.',

            'treatment_id.required' => 'O tratamento é obrigatório.',
            'treatment_id.exists' => 'O tratamento informado não existe.',

            'filter.required' => 'O filtro é obrigatório.',
            'filter.boolean' => 'O filtro deve ser verdadeiro ou falso.',

            'sensitivity_id.required' => 'A sensibilidade é obrigatória.',
            'sensitivity_id.exists' => 'A sensibilidade informada não existe.',

            'name_lens.required' => 'O nome da lente é obrigatório.',
            'name_lens.string' => 'O nome da lente deve ser texto.',

            'laboratory_lens_id.required' => 'O laboratório da lente é obrigatório.',
            'laboratory_lens_id.exists' => 'O laboratório da lente informado não existe.',

            'laboratory_id.required' => 'O laboratório é obrigatório.',
            'laboratory_id.exists' => 'O laboratório informado não existe.',

            'delivery.required' => 'O prazo de entrega é obrigatório.',
            'delivery.numeric' => 'O prazo de entrega deve ser um número.', // alterado de 'integer' para 'numeric' para manter consistência

            'spherical_start.required' => 'O grau esférico inicial é obrigatório.',
            'spherical_start.numeric' => 'O grau esférico inicial deve ser um número.',
            'spherical_end.required' => 'O grau esférico final é obrigatório.',
            'spherical_end.numeric' => 'O grau esférico final deve ser um número.',

            'cylindrical_start.numeric' => 'O grau cilíndrico inicial deve ser um número.',
            'cylindrical_end.numeric' => 'O grau cilíndrico final deve ser um número.',

            'addition_start.numeric' => 'A adição inicial deve ser um número.',
            'addition_end.numeric' => 'A adição final deve ser um número.',

            'diameter_id.required' => 'O diâmetro é obrigatório.',
            'diameter_id.exists' => 'O diâmetro informado não existe.',

            'height_id.required' => 'A altura é obrigatória.',
            'height_id.exists' => 'A altura informada não existe.',

            'cost.numeric' => 'O custo deve ser um número.', // novo campo cost
            'minimum_value.numeric' => 'O valor mínimo deve ser um número.',
            'discount.numeric' => 'O desconto deve ser um número.',

            'price.required' => 'O preço é obrigatório.',
            'price.numeric' => 'O preço deve ser um número.',

            'profit.numeric' => 'O lucro deve ser um número.', // novo campo profit
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
        return $this->belongsTo(Laboratory::class, 'laboratory_id');
    }

    public function laboratoryLens(): BelongsTo {
        return $this->belongsTo(Laboratory::class, 'laboratory_lens_id');
    }

    public function diameters(): BelongsTo {
        return $this->belongsTo(Diameter::class, 'diameter_id');
    }

    public function heights(): BelongsTo {
        return $this->belongsTo(Height::class, 'height_id');
    }
    public function surfacings(): BelongsTo {
        return $this->belongsTo(Surfacing::class, 'surfacing_id');
    }

    public function indices(): BelongsTo {
        return $this->belongsTo(Index::class, 'index_id');
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
