<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AgreementFactory extends Factory {

    protected $agreements = [
        'Clínica de Olhos',
        'Unimed Rondonópolis',
        'Mil Madeiras',
        'Hermasa Navegação'
    ];

    protected static  $i = 0;

    public function definition(): array {
        $currentAgreement = $this->agreements[static::$i % count($this->agreements)];
        static::$i++;

        return [
            'agreement' => $currentAgreement
        ];
    }

    public function resetBrandSequence(): self {
        static::$i = 0;
        return $this;
    }
}
