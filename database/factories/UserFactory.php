<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array {
        return [
            'first_name' => 'Administrador',
            'last_name' => 'do Sistema',
            'is_admin' => 1,
            'is_manager' => 0,
            'discount' => 0,
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin123'),
        ];
    }

    /**
     * @return Factory
     */
    public function unverified(): Factory {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
