<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MultifocalLens extends Model {
    use HasFactory;

    protected $fillable = [
        'barcode',
        'lens_id',
        'spherical',
        'addition',
        'left',
        'right',
        'cropped_lens_left',
        'cropped_lens_right',
    ];

    public function rules(bool $update = false): array {
        return [
            'barcode' => 'sometimes|string|unique',
            'lens_id' => $update ? 'sometimes|exists:lenses,id' : 'required|exists:lenses,id',
            'spherical' => $update ? 'sometimes|numeric' : 'required|numeric',
            'addition' => $update ? 'sometimes|numeric' : 'required|numeric',
            'left' => $update ? 'sometimes|numeric' : 'required|numeric',
            'right' => $update ? 'sometimes|numeric' : 'required|numeric',
            'cropped_lens_left' => $update ? 'sometimes|numeric' : 'required|numeric',
            'cropped_lens_right' => $update ? 'sometimes|numeric' : 'required|numeric',
        ];
    }

    public function messages(): array {
        return [
            'barcode.string' => 'O campo código de barras deve ser uma string.',
            'barcode.unique' => 'O código de barras fornecido já está em uso.',

            'lens_id.required' => 'O campo ID da lente é obrigatório.',
            'lens_id.exists' => 'O ID da lente fornecido não existe.',

            'spherical.required' => 'O campo esférico é obrigatório.',
            'spherical.numeric' => 'O campo esférico deve ser um número.',

            'addition.required' => 'O campo adição é obrigatório.',
            'addition.numeric' => 'O campo adição deve ser um número.',

            'left.required' => 'O campo esquerdo é obrigatório.',
            'left.numeric' => 'O campo esquerdo deve ser um número.',

            'right.required' => 'O campo direito é obrigatório.',
            'right.numeric' => 'O campo direito deve ser um número.',

            'cropped_lens_left.required' => 'O campo lente recortada esquerda é obrigatório.',
            'cropped_lens_left.numeric' => 'O campo lente recortada esquerda deve ser um número.',

            'cropped_lens_right.required' => 'O campo lente recortada direita é obrigatório.',
            'cropped_lens_right.numeric' => 'O campo lente recortada direita deve ser um número.',
        ];
    }

    public function lens():BelongsTo {
        return $this->belongsTo(Lens::class);
    }
}
