<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sensitivity extends Model {
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['sensitivity', 'percentage'];

    # Validations
    public function rules(bool $update = false): array {
        return [
            'sensitivity' => $update ? 'nullable|string' : 'required|string|unique:sensitivities',
            'percentage' => $update ? 'nullable|numeric' : 'required|numeric',
        ];
    }

    public function messages(): array {
        return [
            'sensitivity.required' => 'O campo sensibilidade é obrigatorio.',
            'sensitivity.string' => 'O campo sensibilidade deve ser do tipo texto.',
            'sensitivity.unique' => 'O campo sensibilidade já está cadastrado na base de dados.',

            'percentage.required' => 'O campo porcentagem é obrigatório.',
            'percentage.numeric' => 'O campo procentagem deve ser numérico.',
        ];
    }

    # Relationships
    public function lens(): HasMany {
        return $this->hasMany(Lens::class);
    }
}
