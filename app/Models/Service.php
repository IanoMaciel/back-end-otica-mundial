<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model {
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
    ];

    public function rules(bool $update=false): array {
        return [
            'name' => $update ? 'nullable|string|max:50' : 'required|string|max:50|unique:services',
            'description' => 'nullable|string|max:255',
            'price'=> $update ? 'nullable|numeric' : 'required|numeric',
        ];
    }

    public function messages(): array {
        return [
            'name.required' => 'O campo Nome é obrigatório.',
            'name.string' => 'O campo Nome deve ser do tipo texto.',
            'name.max' => 'O campo Nome não pode exceder o limite de 50 caracteres.',
            'name.unique' => 'O Nome informado já está cadastrado na base de dados.',

            'description.string' => 'O campo Descrição deve ser do tipo texto.',
            'desription.max' => 'O campo Descrição não pode exceder o limite de 255 caracteres.',

            'price.required' => 'O campo Preço é obrigatório.',
            'price.numeric' => 'O campo Preço deve ser do tipo númerico.'
        ];
    }
}
