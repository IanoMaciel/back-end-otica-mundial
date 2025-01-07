<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentMethodFactory extends Factory {

    protected $paymentMethod = [
        'Dinheiro',
        'Pix',
        'Cartão de Débito',
        'Cartão de Crédito',
        'Pag. Combinado',
        'Crediário da Loja',
    ];

    protected static  $i = 0;

    public function definition(): array {
        $currentPaymentMethod = $this->paymentMethod[static::$i % count($this->paymentMethod)];
        static::$i++;

        return [
            'payment_method' => $currentPaymentMethod
        ];
    }

    public function resetPaymentMethodSequence(): self {
        static::$i = 0;
        return $this;
    }
}
