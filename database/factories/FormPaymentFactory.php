<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FormPaymentFactory extends Factory {

    protected $paymentMethod = [
        'Dinheiro',
        'Pix',
        'Cartão de Débito',
        'Cartão de Crédito',
    ];

    protected static  $i = 0;

    public function definition(): array {
        $currentFormPayment = $this->paymentMethod[static::$i % count($this->paymentMethod)];
        static::$i++;

        return [
            'form_payment' => $currentFormPayment
        ];
    }
}
