<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Financial>
 */
class FinancialFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'client_id' => Client::factory(),
            'total_loan_amount_borrowed'=> 0,
            'loan_repayment_status'=> fake()->randomElement(['on-time','overdue','deliquent']),
            'income'=> fake()->numberBetween(10000,100000),
            'credit_score'=> fake()->numberBetween(50,100),
        ];
    }
}
