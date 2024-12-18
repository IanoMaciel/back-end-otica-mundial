<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model {
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'contact',
        'description',
    ];

    /**
     * @return string[]
     */
    public function rules(bool $update = false): array {
        return [
            'name' => $update ? 'required|string|max:60' : 'required|string|max:60|unique:suppliers',
            'email' => 'email',
            'contact' => 'celular_com_ddd',
            'description' => 'string|max:255'
        ];
    }

    /**
     * @return array
     */
    public function messages(): array {
        return [
            'name.required' => 'O campo Nome é obrigatório.',
            'name.string' => 'O Nome deve ser uma string.',
            'name.max' => 'O Nome não pode ter mais que 60 caracteres.',
            'name.unique' => 'O campo Nome já está cadastrado na base de dados.',
            'email.email' => 'O e-mail informado não é válido.',
            'contact.celular_com_ddd' => 'O contato deve ser um número de celular válido com DDD.',
            'description.string' => 'A descrição deve ser uma string.',
            'description.max' => 'A descrição não pode ter mais que 255 caracteres.',
        ];
    }

    # Relationships
    public function frame(): HasMany {
        return $this->hasMany(Frame::class);
    }
}
