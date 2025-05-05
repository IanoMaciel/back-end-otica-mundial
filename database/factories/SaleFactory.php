<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\PaymentMethod;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SaleFactory extends Factory {
    public function definition(): array {
        return [
            'number_ata' => $this->faker->unique()->numerify('ATA-#####'),
            'customer_id' => 1, // Cria um customer novo para o sale
            'user_id' => 1,          // Cria um user novo para o sale
            'payment_method_id' => $this->faker->randomElement([1,2,3,4,5,6]),
            'status' => $this->faker->randomElement(['Pago', 'Pendente', 'Cancelado', 'Atrasado']),
            'total_amount' => $this->faker->randomFloat(2, 100, 5000),
            'date_sale' => now(),
        ];
    }
}
