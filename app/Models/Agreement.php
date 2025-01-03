<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Agreement extends Model {
    use HasFactory;
    protected $fillable = ['agreement'];
    public $timestamps = false;

    public function rules(bool $update=false): array {
        return [
            'agreement' => $update ? 'nullable|string|max:30' : 'required|string|max:30|unique:agreements',
        ];
    }

    public function messages(): array {
        return [
            'agreement.required' =>  'O campo Convênio é obrigatório.',
            'agreement.string' => 'O campo Convênio deve ser do tipo string.',
            'agreement.max' => 'O campo Convênio excedeu o limite de caracteres.',
            'agreement.unique' => 'O Convênio informado já está cadastrado na base de dados.'
        ];
    }

    // Relationships
    public function customers(): HasMany {
        return $this->hasMany(Customer::class);
    }
}
