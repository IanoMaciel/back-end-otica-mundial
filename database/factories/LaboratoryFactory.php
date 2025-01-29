<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class LaboratoryFactory extends Factory {
    protected function generateFormattedPhone(): string {
        $ddd = str_pad(rand(11, 99), 2, '0', STR_PAD_LEFT);
        $firstPart = str_pad(rand(0, 99999), 5, '0', STR_PAD_LEFT);
        $secondPart = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);

        return "({$ddd}){$firstPart}-{$secondPart}";
    }

    public function definition(): array {
        return [
            'laboratory' => $this->faker->sentence(1),
            'contact' => $this->generateFormattedPhone(),
            'email' => $this->faker->email,
        ];
    }
}
