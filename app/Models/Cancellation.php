<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
            'flag' => 'nullable|in:green,orange,red'
        ];
    }

    public function messages(): array {
        return [
            'sale_id.required' => 'O campo venda é obrigatório.',
            'sale_id.exists' => 'A número de venda informada não existe.',
            'reason.string' => 'O motivo deve ser um texto.',
            'observation.string' => 'O campo observação deve ser um texto.',
            'observation.max' => 'O campo observação excedeu o limite de 255 caracteres.',
            'flag.in' => 'O campo flag deve conter um dos seguintes valores: green, orange ou red.'
        ];
    }

    public function sale(): BelongsTo {
        return $this->belongsTo(Sale::class, 'sale_id');
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }
}
