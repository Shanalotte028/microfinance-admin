<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Financial;
use App\Models\Risk;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Risk>
 */
class RiskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'client_id' => Client::factory(),
            'confidence_level' => 0,
            'risk_level' => 'Medium Risk',
            'recommendation' => fake()->sentence(2),
            'assessment_date' => $this->faker->date('Y-m-d', $this->faker->dateTimeBetween('2020-01-01', '2025-12-31')),    
        ];
    }

    public function configure(){
        return $this->afterMaking(function (Risk $risk) {
            // Get associated financial record
            $financial = Financial::where('client_id', $risk->client_id)->first();
            if ($financial) {
                $credit_score = $financial->credit_score;

                // Scale credit score to confidence level
                $confidence_level = (1000 - $credit_score) / 4; 
                $confidence_level = (int) max(0, min(100, $confidence_level)); // Ensure within 0-100 range

                $risk->confidence_level = $confidence_level;
                $risk->risk_level = $this->getRiskLevel($confidence_level);
            }
        });
    }

    /**
     * Determine the risk level based on the risk score.
     *
     * @param int $risk_score
     * @return string
     */
    private function getRiskLevel(int $risk_score): string
    {
        if ($risk_score <= 20) {
            return 'Low Risk';
        } elseif ($risk_score <= 80) {
            return 'Medium Risk';
        } else {
            return 'High Risk';
        }
    }
}
