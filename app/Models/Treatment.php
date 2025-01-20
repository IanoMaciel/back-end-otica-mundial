<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Treatment extends Model {
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['treatment'];

    public function rules(bool $update = false): array {
        return [
            'treatment' => $update ? 'required|string' : 'required|string|unique:treatments',
        ];
    }

    public function messages(): array {
        return [
            'treatment.required' => 'O campo tratamento é obrigatorio.',
            'treatment.string' => 'O campo tratamento deve ser do tipo texto.',
            'treatment.unique' => 'O campo tratamento já está cadastrado na base de dados.'
        ];
    }

    # Relationships
    public function lens(): HasMany {
        return $this->hasMany(Lens::class);
    }
}
