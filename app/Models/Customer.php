<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Customer extends Model {
    use HasFactory;
    protected $fillable = [
        'full_name',
        'cpf',
        'rg',
        'phone_primary',
        'email',
        'agreement_id',
        'number_agreement',
    ];

    public function rules(bool $update=false): array {
        return [
            'full_name' => $update ? 'nullable|string|max:100' : 'required|string|max:100',
            'cpf' => $update ? 'nullable|cpf|formato_cpf' : 'nullable|cpf|formato_cpf|unique:customers',
            'rg' => 'nullable|string',
            'phone_primary' => 'nullable|celular_com_ddd',
            'email' => 'nullable|string|email',
            'agreement_id' => 'nullable|exists:agreements,id',
            'number_agreement' => 'nullable|string',
        ];
    }

    public function messages(): array {
        return [
            'full_name.required' => 'O campo Nome é obrigatório.',
            'full_name.string' => 'O campo Nome deve ser do tipo texto.',
            'full_name.max' => 'O campo Nome não pode exceder 100 caracteres.',

            'cpf.cpf' => 'O CPF informado não é válido.',
            'cpf.formato_cpf' => 'O campo CFP deve estar no seguinte formato: xxx.xxx.xxx-xx',
            'cpf.unique' => 'O CPF informado já está cadastrado na base de dados.',

            'rg' => 'O campo RG deve ser do tipo texto.',
            'phone_primary' => 'O campo Contato deve estar no seguinte formato: (xx)xxxxx-xxxx',

            'email.string' => 'O campo E-mail deve ser do tipo texto.',
            'email.email' => 'O campo E-mail deve ser um endereço válido.',

            'agreement_id.exists' => 'O Convênio informado não existe na base de dados.',
            'number_agreement.string' => 'O campo Número do Convênio deve ser tipo texto.',
        ];
    }

    # Relationships
    public function agreements(): BelongsTo {
        return $this->belongsTo(Agreement::class, 'agreement_id');
    }

    public function address(): HasOne {
        return $this->hasOne(Address::class, 'customer_id');
    }

    public function sales(): HasMany {
        return $this->hasMany(Sale::class, 'customer_id');
    }
}
