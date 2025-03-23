<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Financial;
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
        /// Retrieve a financial record linked to a client
        $financial = Financial::factory()->create();
        $credit_score = $financial->credit_score;

        // Scale credit score (600-1000) to confidence level (0-100)
        $confidence_level = (1000 - $credit_score) / 4; 
        $confidence_level = (int) max(0, min(100, $confidence_level)); // Ensure within 0-100 range

        return [
            'client_id' => $financial->client_id,
            'confidence_level' => $confidence_level,
            'risk_level' => $this->getRiskLevel($confidence_level),
            'recommendation' => fake()->sentence(2),
            'assessment_date' => fake()->dateTimeBetween('-4 years', 'now')->format('Y-m-d'),      
        ];
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
