<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'is_admin',
        'is_manager',
        'discount',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function rules(bool $update = false): array {
        return [
            'first_name' => 'required|string|min:3|max:30',
            'last_name' => 'required|string|max:60',
            'is_admin' => 'boolean',
            'is_manager' => 'boolean',
            'discount' => 'numeric',
            'email' => $update ? 'required|string|email' : 'required|string|email|unique:users',
            'password' => $update ? 'nullable|string|confirmed|min:8' : 'required|string|confirmed|min:8',
        ];
    }

    public function messages(): array {
        return [
            'first_name.required' => 'O campo Nome é obrigatório.',
            'first_name.string' => 'O campo Nome deve conter apenas caracteres alfabéticos.',
            'first_name.min' => 'O campo Nome deve ter no mínimo 3 caracteres.',
            'first_name.max' => 'O campo Nome deve ter no máximo 30 caracteres.',

            'last_name.required' => 'O campo Sobrenome é obrigatório.',
            'last_name.string' => 'O campo Sobrenome deve conter apenas caracteres alfabéticos.',
            'last_name.max' => 'O campo Sobrenome deve ter no máximo 60 caracteres.',

            'is_admin.boolean' => 'O campo Administrador deve ser verdadeiro ou falso.',
            'is_manager.boolean' => 'O campo Gerente deve ser verdadeiro ou falso.',

            'discount.numeric' => 'O campo Desconto deve ser um valor numérico.',

            'email.required' => 'O campo E-mail é obrigatório.',
            'email.string' => 'O campo E-mail deve ser uma string.',
            'email.email' => 'O campo E-mail deve ser um endereço de e-mail válido.',
            'email.unique' => 'O endereço de e-mail já está em uso.',

            'password.required' => 'O campo Senha é obrigatório.',
            'password.string' => 'O campo Senha deve ser uma string.',
            'password.confirmed' => 'A confirmação da senha não corresponde.',
            'password.min' => 'O campo Senha deve ter no mínimo 8 caracteres.',
        ];
    }

    # Relationships
    public function sales(): HasMany {
        return $this->hasMany(Sale::class, 'user_id');
    }

}
