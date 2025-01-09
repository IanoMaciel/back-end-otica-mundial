<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory {

    protected static $customerId = 1;

    public function definition(): array {
        return [
            'customer_id' => self::$customerId++,
            'cep' => $this->faker->postcode,
            'uf' => $this->faker->stateAbbr,
            'city' => $this->faker->city(),
            'street' => $this->faker->streetAddress,
            'number' => $this->faker->numberBetween(1, 99999),
            'neighborhood' => $this->faker->sentence(1),
            'complement' => $this->faker->sentence(1),
            'reference' => $this->faker->sentence(3),
        ];
    }
}
