<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model {
    use HasFactory;
    protected $fillable = ['payment_method'];
    public $timestamps = false;

    public function rules(bool $update=false): array {
        return [
            'payment_method' => $update ? 'nullable|string|max:30' : 'required|string|max:30|unique:payment_methods',
        ];
    }

    public function messages(): array {
        return [
            'payment_method.required' => 'O campo Método de Pagamento é obrigatório.',
            'payment_method.string' => 'O campo método de Pagamento deve ser do tipo texto',
            'payment_method.max' => 'O campo Método de Pagamento não deve exceder o limite de 30 caracteres.',
            'payment_method.unique' => 'O campo Método de Pagamento já está cadastrado na base de dados.',
        ];
    }
}
