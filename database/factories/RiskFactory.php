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
        return [
            'client_id' => Client::factory(),
            'risk_score'=> fake()->numberBetween(50,100),
            'risk_level'=> fake()->randomElement(['low','medium','high']),
            'recommendation'=> fake()->sentence(2),
            'assessment_date' => fake()->date(),      
        ];
    }
}
