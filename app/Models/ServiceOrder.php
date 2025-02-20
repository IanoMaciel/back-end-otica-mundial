<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceOrder extends Model {
    use HasFactory;
    protected $fillable = [
        'sale_id',
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
            'sale_id' => 'sometimes|exists|sales,id',
            'number_ata' => 'required|exists:sales,number_ata',
            'delivery' => 'sometimes|date',
        ];
    }

    public function messages(): array {
        return [
            'number_ata.required' => 'O número da venda é obrigatório.',
            'number_ata.exists' => 'O número da venda informada não existe na base de dados.',
        ];
    }
}
