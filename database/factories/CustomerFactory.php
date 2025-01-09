<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory {

    protected static $usedCpfs = [];
    protected function generateUniqueCpf(): string {
        do {
            $cpf = vsprintf('%s%s%s.%s%s%s.%s%s%s-%s%s', str_split(str_pad(rand(0, 99999999999), 11, '0', STR_PAD_LEFT)));
        } while (in_array($cpf, static::$usedCpfs));

        static::$usedCpfs[] = $cpf;
        return $cpf;
    }

    protected function generateFormattedRg(): string {
        return vsprintf('%s%s%s%s%s%s%s-%s', str_split(str_pad(rand(0, 9999999), 8, '0', STR_PAD_LEFT)));
    }

    protected function generateFormattedPhone(): string {
        $ddd = str_pad(rand(11, 99), 2, '0', STR_PAD_LEFT);
        $firstPart = str_pad(rand(0, 99999), 5, '0', STR_PAD_LEFT);
        $secondPart = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);

        return "({$ddd}){$firstPart}-{$secondPart}";
    }

    public function definition(): array {
        return [
            'full_name' => $this->faker->firstName . ' ' . $this->faker->lastName(),
            'cpf' => $this->generateUniqueCpf(),
            'rg' => $this->generateFormattedRg(),
            'phone_primary' => $this->generateFormattedPhone(),
            'email' => $this->faker->email(),
            'agreement_id' => $this->faker->randomElement([1, 2, 3, 4]),
            'number_agreement' => $this->faker->numberBetween(1, 9999),
        ];
    }

    public static function resetUsedCpfs(): void {
        static::$usedCpfs = [];
    }
}
