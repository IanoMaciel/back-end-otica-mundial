<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class LensFactory extends Factory {
    public function definition(): array {
        return [
            'barcode' => $this->faker->unique()->ean13(), // nullable|string|unique
            'type_lens_id' => $this->faker->randomElement([1, 2]), // required|exists
            'index' => $this->faker->randomFloat(2, 1.5, 1.7), // required|numeric
            'treatment_id' => $this->faker->randomElement([1, 2, 3]), // required|exists
            'filter' => $this->faker->boolean(), // required|boolean
            'sensitivity_id' => $this->faker->randomElement([1, 2, 3, 4, 5]), // required|exists
            'name_lens' => $this->faker->word(), // required|string
            'laboratory_id' => 1, // required|exists
            'minimum_value' => $this->faker->optional()->randomFloat(2, 50, 200), // nullable|numeric
            'discount' => $this->faker->optional()->randomFloat(2, 5, 50), // nullable|numeric
            'price' => $this->faker->randomFloat(2, 100, 500), // required|numeric
            'delivery' => $this->faker->numberBetween(1, 30), // required|integer
            'spherical_start' => $this->faker->randomFloat(2, -20, 0), // required|numeric
            'spherical_end' => $this->faker->randomFloat(2, 0, 20), // required|numeric
            'cylindrical_start' => $this->faker->optional()->randomFloat(2, -6, 0), // nullable|numeric
            'cylindrical_end' => $this->faker->optional()->randomFloat(2, 0, 6), // nullable|numeric
            'addition_start' => $this->faker->optional()->randomFloat(2, 0, 2), // nullable|numeric
            'addition_end' => $this->faker->optional()->randomFloat(2, 2, 4), // nullable|numeric
        ];
    }
}
