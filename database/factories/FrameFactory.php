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
            'brand_id' => $this->faker->randomElement([1,2,3]),
            'material_id' => $this->faker->randomElement([1,2,3]),
            'amount' => $this->faker->numberBetween(1, 100),
            'purchase_value' => $this->faker->randomFloat(2, 10, 500),
            'profit' => $this->faker->randomFloat(2, 0.1, 1),
            'discount' => $this->faker->randomFloat(2, 0, 0.5),
            'price' => function (array $attributes) {
                $price = $attributes['purchase_value'] * (1 + $attributes['profit']);
                return $price * (1 - $attributes['discount']);
            },
            'description' => $this->faker->sentence(10),
        ];
    }
}
