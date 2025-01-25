<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SensitivityFactory extends Factory {

    protected $sensitivity = [
        'Transitions',
        'Essilor Photochromic',
        'Hoya Sensity',
        'Zeiss PhotoFusion',
        'Kodak Transitions',
    ];

    protected static  $i = 0;

    public function definition(): array {
        $currentSensitivity = $this->sensitivity[static::$i % count($this->sensitivity)];
        static::$i++;
        return [
            'sensitivity' => $currentSensitivity,
            'percentage' => $this->faker->randomFloat(2, 0, 100),
        ];
    }
}
