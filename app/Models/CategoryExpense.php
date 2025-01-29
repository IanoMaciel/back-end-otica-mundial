<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CategoryExpense extends Model {
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'category_expense'
    ];

    public function rules(bool $update = false): array {
        return [
            'category_expense' => $update ? 'required|string|max:30|' : 'required|string|max:30|unique:category_expenses',
        ];
    }

    public function messages(): array {
        return [
            'category_expense.required' => 'O campo categoria de despesa é obrigatórtio.',
            'category_expense.string' => 'O campo categoria de despesa deve ser do tipo texto.',
            'category_expense.max' => 'O campo categoria de despesa excedeu o limite de 30 caracteres.',
            'category_expense.unique' => 'O campo categoria de despesa já existe na base de dados.',
        ];
    }

    public function expense(): HasMany {
        return $this->hasMany(Expense::class);
    }
}
