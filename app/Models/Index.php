<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Index extends Model {
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['index'];

    public function rules(bool $update = false): array {
        return [
            'index' => $update ? 'required|numeric' : 'required|numeric|unique:indices,index',
        ];
    }

    public function messages(): array {
        return [
            'index.required' => 'O campo índice é um campo obrigatório.',
            'index.numeric' => 'O campo índice deve ser do tipo numérico.',
            'index.unique' => 'O índice já existe na base de dados.',
        ];
    }

    public function lens(): HasMany {
        return $this->hasMany(Lens::class);
    }
}
