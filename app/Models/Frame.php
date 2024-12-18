<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        'discount',
        'price',
        'description'
    ];

    public function rules(): array {
        return [
            'code' => 'required|numeric',
            'size' => 'required|numeric',
            'haste' => 'required|numeric',
            'bridge' => 'required|numeric',
            'color' => 'string|max:30',
            'amount' => 'required|numeric',
            'purchase_value' => 'required|numeric',
            'profit' => 'required|numeric|gt:0',
            'discount' => 'numeric|min:0|max:100',
            'price' => 'required|numeric|gt:0',
            'description' => 'string|max:255',
            'supplier_id' => 'required|exists:suppliers,id',
            'brand_id' => 'required|exists:brands,id',
            'material_id' => 'required|exists:materials,id',
        ];
    }

    public function messages(): array {
        return [
            'code.required' => 'O campo código é obrigatório.',
            'code.numeric' => 'O campo código deve ser um valor numérico.',

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

            'purchase_value.required' => 'O campo valor de compra é obrigatório.',
            'purchase_value.numeric' => 'O campo valor de compra deve ser um valor numérico.',

            'profit.required' => 'O campo lucro é obrigatório.',
            'profit.numeric' => 'O campo lucro deve ser um valor numérico.',
            'profit.gt' => 'O campo lucro deve ser maior que zero.',

            'discount.numeric' => 'O campo desconto deve ser um valor numérico.',
            'discount.min' => 'O campo desconto não pode ser negativo.',
            'discount.max' => 'O campo desconto não pode exceder 100%.',

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
}
