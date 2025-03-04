<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BrandFactory extends Factory {

    protected  $brands = [
        'Ray Ban',
        'Oakley',
        'Prada',
        'Gucci'
    ];

    protected static  $i = 0;

    public function definition(): array {
        $currentBrand = $this->brands[static::$i % count($this->brands)];
        static::$i++;

        return [
            'brand' => $currentBrand,
            'discount' => $this->faker->randomElement([10, 40]),
        ];
    }

    public function resetBrandSequence(): self {
        static::$i = 0;
        return $this;
    }
}
