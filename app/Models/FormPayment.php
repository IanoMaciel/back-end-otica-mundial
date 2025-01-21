<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FormPayment extends Model {
    use HasFactory;
    protected $fillable = ['form_payment'];

    public function rules(bool $update=false): array {
        return [
            'form_payment' => $update ? 'required|string|max:30|' : 'required|string|max:30|unique:form_payments',
        ];
    }

    public function messages(): array {
        return [
            'form_payment.required' => 'O campo forma de pagamento é obrigatório',
            'form_payment.string' => 'O campo forma de pagamento deve ser do tipo texto',
            'form_payment.max' => 'A forma de pagamento informada excedeu o tamanho de 30 caracteres.',
            'form_payment.unique' => 'A forma de pagamento informada já está registrado na base de dados.',
        ];
    }

    public function combinedPayment(): HasMany {
        return $this->hasMany(HasMany::class);
    }
}
