<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Filter extends Model {
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'promotion_id',
        'type',
        'name',
    ];

    public function rules(): array {
        return [
            'promotion_id' => 'nullable|exists:promotions,id',
            'type' => 'nullable|string',
            'name' => 'nullable|string',
        ];
    }

    public function messages(): array {
        return [
            'type.required' => 'O campo type é obrigatório.',
            'type.string' => 'O campo type deve ser uma string.',

            'name.required' => 'O campo name é obrigatório.',
            'name.string' => 'O campo name deve ser uma string.',
        ];
    }

    # relationships
    public function promotion(): BelongsTo {
        return $this->belongsTo(Promotion::class);
    }
}
