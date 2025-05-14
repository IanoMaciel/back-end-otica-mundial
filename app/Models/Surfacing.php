<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Surfacing extends Model {
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['surfacing'];

    public function rules(): array {
        return [
            'surfacing' => 'required|string',
        ];
    }

    public function messages(): array {
        return [
            'surfacing.required' => 'O campo surfaçagem é um campo obrigatório.',
            'surfacing.string' => 'O campo surfaçagem deve ser do tipo texto.',
        ];
    }
}
