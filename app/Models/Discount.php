<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Discount extends Model {
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['discount_type'];

    public function rules(bool $update = false): array {
        return [
            'discount_type' => $update ? 'sometimes|string|max:30' : 'required|string|max:30|unique:discounts'
        ];
    }

    public function messages(): array {
        return [
            'discount_type.required' => 'O campo desconto é obrigatório.',
            'discount_type.string' => 'O campo desconto é do tipo texto.',
            'discount_type.max' => 'O campo desconto não deve exceder o tamanho de 30 caracteres.',
            'discount_type.unique' => 'O nome informado para o desconto já existe na base de dados.',
        ];
    }

    # relationships

    public function saleItems(): HasMany {
        return $this->hasMany(SaleItem::class);
    }
}
