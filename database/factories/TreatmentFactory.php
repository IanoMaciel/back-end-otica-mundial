<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TreatmentFactory extends Factory {
    protected $treatment = [
        'Verde',
        'Azul',
        'Antiembaçante',
    ];

    protected static  $i = 0;

    public function definition(): array {
        $currentTreatment = $this->treatment[static::$i % count($this->treatment)];
        static::$i++;
        return [
            'treatment' => $currentTreatment
        ];
    }
}
