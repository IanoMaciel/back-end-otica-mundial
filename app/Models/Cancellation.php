<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cancellation extends Model {
    use HasFactory;
    protected $fillable = [
        'sale_id',
        'user_id',
        'reason',
        'observation'
    ];

    public function rules(): array {
        return [
            'sale_id' => 'required|exists:sales,id',
            'reason' => 'nullable|string',
            'observation' => 'nullable|string|max:255',
        ];
    }

    public function messages(): array {
        return [
            'sale_id.required' => 'O campo venda é obrigatório.',
            'sale_id.exists' => 'A venda informada não existe.',
            'reason.string' => 'O motivo deve ser um texto.',
            'observation.string' => 'O campo observação deve ser um texto.',
            'observation.max' => 'O campo observação excedeu o limite de 255 caracteres.',
        ];
    }
}
