<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Brand extends Model {
    use HasFactory;
    protected $fillable = ['brand', 'discount'];

    /**
     * @return string[]
     */
    public function rules(bool $update = false): array {
        return [
            'brand' => $update ? 'required|string|max:30' : 'required|string|max:30|unique:brands',
            'discount' => 'numeric'
        ];
    }

    public function messages(): array {
        return [
            'brand.required' => 'O campo Grife é obrigatório.',
            'brand.string' => 'O campo Grife deve ser uma string.',
            'brand.unique' => 'A Grife já está cadastrada na base dados.',
            'brand.max' => 'O campo Grife não pode ter mais do que 30 caracteres.',
            'discount.numeric' => 'O campo Desconto deve ser um valor numérico.'
        ];
    }

    # Relationships
    public function frame(): BelongsTo {
        return $this->belongsTo(Frame::class);
    }
}
