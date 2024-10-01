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
            'loan_amount'=> fake()->numberBetween(1000,10000),
            'loan_status'=> fake()->randomElement(['active','closed','defaulted']),
            'interest_rate'=> fake()->numberBetween(100,1000),
            'start_date'=> Carbon::now()->format('Y-m-d'),
            'end_date'=> Carbon::now()->addDays(12)->format('Y-m-d'),
        ];
    }
}
