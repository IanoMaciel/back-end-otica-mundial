<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Laboratory extends Model {
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['laboratory', 'contact', 'email'];

    public function rules(bool $update = false): array {
        return [
            'laboratory' => $update ? 'required|string|max:30|' : 'required|string|max:30|unique:laboratories',
            'contact' => 'nullable|celular_com_ddd',
            'email' => 'nullable|email'
        ];
    }

    public function messages(): array {
        return [
            'laboratory.required' => 'O campo laboratório de despesa é obrigatórtio.',
            'laboratory.string' => 'O campo laboratório de despesa deve ser do tipo texto.',
            'laboratory.max' => 'O campo laboratório de despesa excedeu o limite de 30 caracteres.',
            'laboratory.unique' => 'O campo laboratório de despesa já existe na base de dados.',

            'contact.celular_com_ddd' => 'O campo contato deve estar no formato válido com DDD.',

            'email.email' => 'O campo email deve ser um endereço de email válido.',
        ];
    }

    # Relationships
    public function lens(): HasMany {
        return $this->hasMany(Lens::class);
    }
}
