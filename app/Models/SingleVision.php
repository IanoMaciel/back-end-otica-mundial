<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SingleVision extends Model {
    use HasFactory;

    protected $fillable = [
        'barcode',
        'lens_id',
        'spherical',
        'cylindrical',
        'quantity',
        'cropped_lens'
    ];

    public function rules(bool $update = false): array {
        return [
            'barcode' => 'sometimes|string|unique',
            'lens_id' => $update ? 'sometimes|exists:lenses,id' : 'required|exists:lenses,id',
            'spherical' => $update ? 'sometimes|numeric' : 'required|numeric',
            'cylindrical' => $update ? 'sometimes|numeric' : 'required|numeric',
            'quantity' => $update ? 'sometimes|numeric' : 'required|numeric',
            'cropped_lens' => $update ? 'sometimes|numeric' : 'required|numeric',
        ];
    }

    public function messages(): array {
        return [
            'barcode.string' => 'O código de barras deve ser uma string.',
            'barcode.unique' => 'O código de barras já está em uso.',

            'lens_id.required' => 'O ID da lente é obrigatório.',
            'lens_id.exists' => 'O ID da lente fornecido não existe no banco de dados.',

            'spherical.required' => 'O valor esférico é obrigatório.',
            'spherical.numeric' => 'O valor esférico deve ser um número.',

            'cylindrical.required' => 'O valor cilíndrico é obrigatório.',
            'cylindrical.numeric' => 'O valor cilíndrico deve ser um número.',

            'quantity.required' => 'A quantidade é obrigatória.',
            'quantity.numeric' => 'A quantidade deve ser um número.',

            'cropped_lens.required' => 'O valor da lente cortada é obrigatório.',
            'cropped_lens.numeric' => 'O valor da lente cortada deve ser um número.',
        ];
    }

    public function lens():BelongsTo {
        return $this->belongsTo(Lens::class);
    }
}
