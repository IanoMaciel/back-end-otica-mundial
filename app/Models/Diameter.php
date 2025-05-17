<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Diameter extends Model {
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['diameter'];

    public function rules(bool $update = false): array {
        return [
            'diameter' => $update ? 'required|numeric' : 'required|numeric|unique:diameters,diameter',
        ];
    }

    public function messages(): array {
        return [
            'diameter.required' => 'O campo diâmetro é um campo obrigatório.',
            'diameter.numeric' => 'O campo diâmetro deve ser do tipo numérico.',
            'diameter.unique' => 'O diâmetro já existe na base de dados.',
        ];
    }

    public function lens(): HasMany {
        return $this->hasMany(Lens::class);
    }
}
