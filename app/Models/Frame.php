<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Frame extends Model {

    use HasFactory;

    protected $fillable = [
        'barcode',
        'code',
        'size',
        'haste',
        'bridge',
        'color',
        'supplier_id',
        'brand_id',
        'material_id',
        'amount',
        'purchase_value',
        'profit',
        'price',
        'description'
    ];

    public function rules(bool $update=false): array {
        return [
            'code' => $update ? 'required|string' : 'required|string|unique:frames',
            'size' => $update ? 'nullable|numeric' : 'required|numeric',
            'haste' => $update ? 'nullable|numeric' : 'required|numeric',
            'bridge' => $update ? 'nullable|numeric' : 'required|numeric',
            'color' => 'nullable|string|max:30',
            'amount' => $update ? 'nullable|numeric' : 'required|numeric',
            'purchase_value' => 'nullable|numeric',
            'profit' => 'nullable|numeric',
            'price' => $update ? 'nullable|numeric|gt:0' : 'required|numeric|gt:0',
            'description' => 'nullable|max:255',
            'supplier_id' => $update ? 'nullable|exists:suppliers,id' : 'required|exists:suppliers,id',
            'brand_id' => $update ? 'nullable|exists:brands,id' : 'required|exists:brands,id',
            'material_id' => $update ? 'nullable|exists:materials,id' : 'required|exists:materials,id',
        ];
    }

    public function messages(): array {
        return [
            'code.required' => 'O campo código é obrigatório.',
            'code.string' => 'O campo código deve ser um valor texto.',
            'code.unique' => 'O código já está cadastrado na base de dados.',

            'size.required' => 'O campo tamanho é obrigatório.',
            'size.numeric' => 'O campo tamanho deve ser um valor numérico.',

            'haste.required' => 'O campo haste é obrigatório.',
            'haste.numeric' => 'O campo haste deve ser um valor numérico.',

            'bridge.required' => 'O campo ponte é obrigatório.',
            'bridge.numeric' => 'O campo ponte deve ser um valor numérico.',

            'color.string' => 'O campo cor deve ser uma string.',
            'color.max' => 'O campo cor não pode exceder 30 caracteres.',

            'amount.required' => 'O campo quantidade é obrigatório.',
            'amount.numeric' => 'O campo quantidade deve ser um valor numérico.',

            'purchase_value.numeric' => 'O campo valor de compra deve ser um valor numérico.',

            'profit.numeric' => 'O campo lucro deve ser um valor numérico.',

            'price.required' => 'O campo preço é obrigatório.',
            'price.numeric' => 'O campo preço deve ser um valor numérico.',
            'price.gt' => 'O campo preço deve ser maior que zero.',

            'description.string' => 'O campo descrição deve ser uma string.',
            'description.max' => 'O campo descrição não pode exceder 255 caracteres.',

            'supplier_id.required' => 'O campo fornecedor é obrigatório.',
            'supplier_id.exists' => 'O fornecedor selecionado não existe.',

            'brand_id.required' => 'O campo marca é obrigatório.',
            'brand_id.exists' => 'A marca selecionada não existe.',

            'material_id.required' => 'O campo material é obrigatório.',
            'material_id.exists' => 'O material selecionado não existe.',
        ];
    }

    # relationships

    public function brands(): BelongsTo {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function materials(): BelongsTo {
        return $this->belongsTo(Material::class, 'material_id');
    }

    public function suppliers(): BelongsTo {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function promotionItems(): MorphMany {
        return $this->morphMany(PromotionItem::class, 'promotionable');
    }
}
