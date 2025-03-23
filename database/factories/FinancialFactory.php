<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Financial;
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

        $credit_score = fake()->numberBetween(600, 1000);

        // Default probability: Higher credit score → Lower defaults
        $random = fake()->numberBetween(1, 100);
        if ($credit_score > 850) {
            $loan_defaults = ($random <= 90) ? 0 : fake()->numberBetween(1, 2);
        } elseif ($credit_score > 750) {
            $loan_defaults = ($random <= 80) ? 0 : fake()->numberBetween(1, 3);
        } else {
            $loan_defaults = ($random <= 60) ? 0 : fake()->numberBetween(1, 3);
        }

        
        return [
            //
            'client_id' => Client::factory(),
            'total_loan_amount_borrowed'=> 0,
            /* 'loan_repayment_status'=> fake()->randomElement(['on-time','overdue','deliquent']), */
            'late_payments'=> fake()->numberBetween(0,10),
            'loan_defaults' => $loan_defaults, // Adjusted probability
            'number_of_payments'=> fake()->numberBetween(0,30),
            'monthly_income'=> 0,
            'annual_income'=> 0,
            'monthly_expenses' => fake()->numberBetween(10000,100000),
            'savings_account_balance'=> fake()->numberBetween(10000,100000),
            'checking_account_balance'=> fake()->numberBetween(10000,100000),
            'total_assets'=> fake()->numberBetween(10000,100000),
            'networth'=> fake()->numberBetween(10000,100000),
            'credit_score' => $credit_score, // Store the credit score
        ];
    }

        public function configure(){
        return $this->afterMaking(function (Financial $financial) {
            // Fetch the associated client
            $client = Client::find($financial->client_id);
            if ($client) {
                $job_status = $client->job_temporary;

                // Adjust income based on job status
                $annual_income = ($job_status === 'Unemployed') 
                    ? fake()->numberBetween(50000, 500000)  
                    : fake()->numberBetween(100000, 1000000);

                $financial->annual_income = $annual_income;
                $financial->monthly_income = (int) ($annual_income / 12);
            }
        });
    }
}