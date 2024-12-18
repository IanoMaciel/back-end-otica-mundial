<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Material extends Model
{
    use HasFactory;

    protected $fillable = ['material'];
    public $timestamps = false;

    public function rules(bool $update = false): array {
        return [
            'material' => $update ? 'required|string|max:30' : 'required|string|max:30|unique:materials'
        ];
    }

    public function messages(): array {
        return [
            'material.required' => 'O campo Material é obrigatório.',
            'material.string' => 'O campo Material deve ser uma string.',
            'material.max' => 'O campo Material não pode ter mais do que 30 caracteres.',
            'material.unique' => 'O material já está cadastrado.'
        ];
    }

    # Relationships
    public function frame(): HasMany {
        return $this->hasMany(Frame::class);
    }
}
