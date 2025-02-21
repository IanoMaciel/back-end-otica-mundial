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
        'number_ata',
        'delivery',
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
        'major_horizontal',
        'minor_horizontal',
        'dnp_v_left',
        'dnp_v_right',
        'alt_left',
        'alt_right'
    ];

    public function rules(): array {
        return [
            'sale_id' => 'sometimes|exists:sales,id',
            'number_os' => 'required|string',
            'number_ata' => 'required|exists:sales,number_ata',
            'delivery' => 'sometimes|date',
            'spherical_left' => 'sometimes|string',
            'spherical_right' => 'sometimes|string',
            'cylindrical_left' => 'sometimes|string',
            'cylindrical_right' => 'sometimes|string',
            'axis_left' => 'sometimes|string',
            'axis_right' => 'sometimes|string',
            'dnp_left' => 'sometimes|string',
            'dnp_right' => 'sometimes|string',
            'height_left' => 'sometimes|string',
            'height_right' => 'sometimes|string',
            'addition_left' => 'sometimes|string',
            'addition_right' => 'sometimes|string',
            'bridge' => 'sometimes|string',
            'major_horizontal' => 'sometimes|string',
            'minor_horizontal' => 'sometimes|string',
            'dnp_v_left' => 'sometimes|string',
            'dnp_v_right' => 'sometimes|string',
            'alt_left' => 'sometimes|string',
            'alt_right' => 'sometimes|string',
        ];
    }

    public function messages(): array {
        return [
            'sale_id.exists' => 'O ID da venda informado não existe na base de dados.',
            'number_os.required' => 'O número da ordem de serviço é obrigatório.',
            'number_ata.required' => 'O número da venda é obrigatório.',
            'number_ata.exists' => 'O número da venda informado não existe na base de dados.',
            'delivery.date' => 'A data de entrega deve ser uma data válida.',
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
            'major_horizontal.string' => 'O campo Horizontal Maior deve ser um texto.',
            'minor_horizontal.string' => 'O campo Horizontal Menor deve ser um texto.',
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
