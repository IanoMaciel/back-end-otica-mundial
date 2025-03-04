<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DiscountFactory extends Factory {

    protected $discounts = [
        'Dinheiro',
        'Pix',
        'Débito',
        'Crédito',
        'Vendedor',
        'Gerente',
        'Administrador'
    ];

    protected static $index = 0;

    public function definition(): array {
        $discount = $this->discounts[static::$index % count($this->discounts)];
        static::$index++;
        return [
            'discount_type' => $discount
        ];
    }
}
