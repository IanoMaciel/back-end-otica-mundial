<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceOrder extends Model {
    use HasFactory;
    protected $fillable = [
        'sale_id',
        'number_os',
        'delivery',
        'observation',

        'spherical_left',
        'spherical_right',
        'cylindrical_left',
        'cylindrical_right',
        'axis_left',
        'axis_right',
        'dnp_left',
        'dnp_right',
        'height_left',
        'height_right',
        'addition_left',
        'addition_right',

        'bridge',
        'larger_horizontal',
        'larger_vertical',
        'larger_diagonal',
        'dnp_v_left',
        'dnp_v_right',
        'alt_left',
        'alt_right',
    ];

    public function rules(): array {
        return [
            'sale_id' => 'required|exists:sales,id',
            'number_os' => 'required|string',
            'delivery' => 'nullable|date',
            'observation' => 'nullable|string|max:255',

            'spherical_left' => 'nullable|string',
            'spherical_right' => 'nullable|string',
            'cylindrical_left' => 'nullable|string',
            'cylindrical_right' => 'nullable|string',
            'axis_left' => 'nullable|string',
            'axis_right' => 'nullable|string',
            'dnp_left' => 'nullable|string',
            'dnp_right' => 'nullable|string',
            'height_left' => 'nullable|string',
            'height_right' => 'nullable|string',
            'addition_left' => 'nullable|string',
            'addition_right' => 'nullable|string',

            'bridge' => 'nullable|string',
            'larger_horizontal' => 'nullable|string',
            'larger_vertical' => 'nullable|string',
            'larger_diagonal' => 'nullable|string',
            'dnp_v_left' => 'nullable|string',
            'dnp_v_right' => 'nullable|string',
            'alt_left' => 'nullable|string',
            'alt_right' => 'nullable|string',
        ];
    }

    public function messages(): array {
        return [
            'sale_id.required' => 'A número da venda é um campo obrigatório.',
            'sale_id.exists' => 'O ID da venda informado não existe na base de dados.',
            'number_os.required' => 'O número da ordem de serviço é obrigatório.',
            'delivery.date' => 'A data de entrega deve ser uma data válida.',
            'observation.string' => 'O campo Observação deve ser um texto.',

            'spherical_left.string' => 'O campo Esférico (OE) deve ser um texto.',
            'spherical_right.string' => 'O campo Esférico (OD) deve ser um texto.',
            'cylindrical_left.string' => 'O campo Cilíndrico (OE) deve ser um texto.',
            'cylindrical_right.string' => 'O campo Cilíndrico (OD) deve ser um texto.',
            'axis_left.string' => 'O campo Eixo (OE) deve ser um texto.',
            'axis_right.string' => 'O campo Eixo (OD) deve ser um texto.',
            'dnp_left.string' => 'O campo DNP (OE) deve ser um texto.',
            'dnp_right.string' => 'O campo DNP (OD) deve ser um texto.',
            'height_left.string' => 'O campo Altura (OE) deve ser um texto.',
            'height_right.string' => 'O campo Altura (OD) deve ser um texto.',
            'addition_left.string' => 'O campo Adição (OE) deve ser um texto.',
            'addition_right.string' => 'O campo Adição (OD) deve ser um texto.',

            'bridge.string' => 'O campo Ponte deve ser um texto.',
            'larger_horizontal.string' => 'O campo Horizontal Maior deve ser um texto.',
            'larger_vertical.string' => 'O campo Vertical Maior deve ser um texto.',
            'larger_diagonal.string' => 'O campo Diagonal Maior deve ser um texto.',
            'dnp_v_left.string' => 'O campo DNP V (OE) deve ser um texto.',
            'dnp_v_right.string' => 'O campo DNP V (OD) deve ser um texto.',
            'alt_left.string' => 'O campo ALT (OE) deve ser um texto.',
            'alt_right.string' => 'O campo ALT (OD) deve ser um texto.',
        ];
    }


    # relationships
    public function sale(): BelongsTo {
        return $this->belongsTo(Sale::class);
    }
}
