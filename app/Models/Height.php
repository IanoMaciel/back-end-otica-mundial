<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Height extends Model {
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['height'];

    public function rules(bool $update = false): array {
        return [
            'height' => $update ? 'required|string' : 'required|string|unique:heights,height',
        ];
    }

    public function messages(): array {
        return [
            'height.required' => 'O campo altura é um campo obrigatório.',
            'height.string' => 'O campo altura deve ser do tipo texto.',
            'height.unique' => 'A altura já existe na base de dados',
        ];
    }

    public function lens(): HasMany {
        return $this->hasMany(Lens::class);
    }
}
