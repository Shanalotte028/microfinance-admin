<?php

namespace Database\Factories;

use App\Models\Client;
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
        $confidence_level = $this->faker->numberBetween(0, 100);

        return [
            'client_id' => Client::factory(),
            'confidence_level'=> $confidence_level,
            'risk_level'=> $this->getRiskLevel($confidence_level),
            'recommendation'=> fake()->sentence(2),
            'assessment_date' => fake()->date(),      
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
        if ($risk_score <= 33) {
            return 'Low Risk';
        } elseif ($risk_score <= 66) {
            return 'Medium Risk';
        } else {
            return 'High Risk';
        }
    }
}
