<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MaterialFactory extends Factory {
    /**
     * @return array
     */
    public function definition(): array{
        return [
            'material' => $this->faker->word()
        ];
    }
}
