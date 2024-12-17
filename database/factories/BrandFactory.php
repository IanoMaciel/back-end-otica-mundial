<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BrandFactory extends Factory {

    /**
     * @return array
     */
    public function definition(): array {
        return [
            'brand' => $this->faker->userName(),
            'discount' => $this->faker->randomElement([1, 10]),
        ];
    }
}
