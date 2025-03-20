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
            /* 'loan_repayment_status'=> fake()->randomElement(['on-time','overdue','deliquent']), */
            'late_payments'=> fake()->numberBetween(0,30),
            'loan_defaults'=> fake()->numberBetween(0,30),
            'number_of_payments'=> fake()->numberBetween(0,30),
            'annual_income'=> fake()->numberBetween(100000,1000000),
            'monthly_income'=> fake()->numberBetween(10000,100000),
            'monthly_expenses' => fake()->numberBetween(10000,100000),
            'savings_account_balance'=> fake()->numberBetween(10000,100000),
            'checking_account_balance'=> fake()->numberBetween(10000,100000),
            'total_assets'=> fake()->numberBetween(10000,100000),
            'networth'=> fake()->numberBetween(10000,100000),
            'credit_score'=> fake()->numberBetween(600,1000),
        ];
    }
}
