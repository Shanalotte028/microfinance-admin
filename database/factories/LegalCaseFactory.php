<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class LegalCaseFactory extends Factory
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
            'client_id' => Client::factory(), // Create a new client if not provided
            'assigned_to' => User::factory(), // Create a new user (lawyer) if not provided
            'case_number' => $this->faker->unique()->numerify('CASE-####'), // Unique case number
            'title' => $this->faker->sentence, // Random title
            'description' => $this->faker->paragraph, // Random description
            'status' => $this->faker->randomElement(['open', 'in_progress', 'closed']), // Random status
            'filing_date' => $this->faker->date(), // Random filing date
            'closing_date' => $this->faker->optional()->date(), // Random closing date (nullable)
        ];
    }
}
