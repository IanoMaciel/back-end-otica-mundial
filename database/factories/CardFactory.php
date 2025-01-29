<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CardFactory extends Factory
{

    protected $numberInstallment = [1, 2, 3, 4, 5, 6];
    protected $interestRate = [3.64, 4.97, 5.89, 6.80, 7.69, 8.58];

    protected static $i = 0;

    public function definition(): array {
        $currentNumberInstallment = $this->numberInstallment[static::$i % count($this->numberInstallment)];
        $currentInterestRate = $this->interestRate[static::$i % count($this->interestRate)];

        static::$i++;

        return [
            'number_installment' => $currentNumberInstallment,
            'interest_rate' => $currentInterestRate,
        ];
    }
}
