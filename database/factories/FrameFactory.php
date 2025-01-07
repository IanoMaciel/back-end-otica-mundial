<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FrameFactory extends Factory {

    /**
     * @return array
     */
    public function definition(): array {
        return [
            'barcode' => $this->faker->unique()->ean13(),
            'code' => $this->faker->unique()->ean13(),
            'size' => $this->faker->numberBetween(10, 20),
            'haste' => $this->faker->numberBetween(100, 130),
            'bridge' => $this->faker->numberBetween(100, 130),
            'color' => $this->faker->safeColorName(),
            'supplier_id' => $this->faker->randomElement([1,2,3]),
            'brand_id' => $this->faker->randomElement([1,2,3,4]),
            'material_id' => $this->faker->randomElement([1,2,3]),
            'amount' => $this->faker->numberBetween(1, 2),
            'purchase_value' => $this->faker->randomFloat(2, 10, 500),
            'profit' => $this->faker->randomFloat(2, 0.1, 1),
            'price' => $this->faker->numberBetween(100, 2000),
            'description' => $this->faker->sentence(10),
        ];
    }
}
