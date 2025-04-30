<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Financial;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Loan>
 */
class LoanFactory extends Factory
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
            'financial_id' => Financial::factory(),
            'submitted_at' => $this->faker->dateTimeBetween('2020-01-01', '2025-12-31')->format('Y-m-d'),
            'loan_status' => fake()->randomElement(['pending','processing','approved', 'rejected', 'active', 'finished', 'default', 'review']),
            'principal_amount'=> fake()->numberBetween(1000,10000),
            'interest_rate'=> fake()->numberBetween(5,30),
            'term_type'=> fake()->randomElement(['Weeks', 'Months', 'Years']),
            'loan_term' => fake()->numberBetween(5,30),
            'payment_frequency_method'=> fake()->randomElement(['Weekly', 'Monthly', 'Yearly']),
            'installment' => fake()->numberBetween(1000,10000),
            'loan_description' => fake()->randomElement(['Personal', 'Education', 'Medical', 'Business', 'Home Improvement', 'Other']),
            /* 'start_date'=> Carbon::now()->format('Y-m-d'), */
            'end_date'=> Carbon::now()->addDays(12)->format('Y-m-d'),
        ];
    }
}
