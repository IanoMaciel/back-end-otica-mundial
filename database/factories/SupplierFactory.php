<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SupplierFactory extends Factory {

    /**
     * @return array
     */
    public function definition(): array {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
            'contact' => $this->faker->phoneNumber(),
            'description' => $this->faker->text(100),
        ];
    }
}
