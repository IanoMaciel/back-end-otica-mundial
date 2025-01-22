<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Expense extends Model {
    use HasFactory;
    protected $fillable = [
        'title',
        'category_expense_id',
        'user_id',
        'total_amount',
        'date_proof',
        'proof',
    ];

    public function rules(bool $update = false): array {
        return [
            'title' => $update ? 'nullable|string|max:100' : 'required|string|max:100',
            'category_expense_id' => $update ? 'nullable|exists:category_expenses,id' : 'required|exists:category_expenses,id',
            'user_id' => $update ? 'nullable|exists:users,id' : 'required|exists:users,id',
            'total_amount' => $update ? 'nullable|numeric' : 'required|numeric',
            'date_proof' => $update ? 'nullable|date' : 'required|date',
            'proof' => 'nullable|array',
            'proof.*' => 'file|mimes:png,jpeg,pdf|max:2048'
        ];
    }

    public function messages(): array {
        return [
            'title.required' => 'O título é obrigatório.',
            'title.string' => 'O título deve ser uma string.',
            'title.max' => 'O título não pode ter mais de 100 caracteres.',
            'category_expense_id.required' => 'A categoria é obrigatória.',
            'category_expense_id.exists' => 'A categoria informada não existe.',
            'user_id.required' => 'O usuário é obrigatório.',
            'user_id.exists' => 'O usuário informado não existe.',
            'total_amount.required' => 'O valor total é obrigatório.',
            'total_amount.numeric' => 'O valor total deve ser numérico.',
            'date_proof.required' => 'A data do comprovante é obrigatória.',
            'date_proof.date' => 'A data do comprovante deve ser uma data válida.',
            'proof.array' => 'Os comprovantes devem ser um array.',
            'proof.*.file' => 'Cada comprovante deve ser um arquivo.',
            'proof.*.mimes' => 'Cada comprovante deve ser um arquivo do tipo: png, jpeg, pdf.',
            'proof.*.max' => 'Cada comprovante não pode ser maior que 2MB.',
        ];
    }

    public function categoryExpenses(): BelongsTo {
        return $this->belongsTo(CategoryExpense::class);
    }
}
