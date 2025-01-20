<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeLens extends Model {
    use HasFactory;
    protected $fillable = ['type_lens'];
    public $timestamps = false;

    public function rules(bool $update = false): array {
        return [
            'type_lens' => $update ? 'required|string' : 'required|string|unique:type_lenses',
        ];
    }

    public function messages(): array {
        return [
            'type_lens.required' => 'O campo tipo da lente é obrigatorio.',
            'type_lens.string' => 'O campo tipo da lente deve ser do tipo texto.',
            'type_lens.unique' => 'O campo tipo da lente já está cadastrado na base de dados.'
        ];
    }
}
