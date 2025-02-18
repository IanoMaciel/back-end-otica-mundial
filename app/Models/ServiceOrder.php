<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceOrder extends Model {
    use HasFactory;
    protected $fillable = [
        'number_ata'
    ];

    public function rules(): array {
        return [
            'number_ata' => 'required|exists:sales,number_ata'
        ];
    }

    public function messages(): array {
        return [
            'number_ata.required' => 'O número da venda é obrigatório.',
            'number_ata.exists' => 'O número da venda informada não existe na base de dados.',
        ];
    }
}
