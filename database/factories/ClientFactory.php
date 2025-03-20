<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $id = 1;
        return [
            'client_id' => $id++,
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->email(),
            'phone_number' => $this->faker->phoneNumber(),
            'birthday' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'place_of_birth' => $this->faker->randomElement(['Quezon City', 'Caloocan City', 'Davao City', 'Taguig', 'Manila', 'Zamboanga', 'Cebu City', 'Antipolo']),
            'gender' => $this->faker->randomElement(['Male', 'Female', 'Other']),
            /* 'nationality' => 'Filipino', */
            'marital_status' => $this->faker->randomElement(['Single', 'Married']),
            'source_of_income' => $this->faker->randomElement(['Employment Income', 'Business Income']), //primary source
            'number_of_dependents' => fake()->numberBetween(0,5),
            'job_temporary' => $this->faker->randomElement(['Employed', 'Self-Employed', 'Unemployed']),
            'education_level' => $this->faker->randomElement(['Bachelor', 'High School', 'Master', 'Doctorate', 'Vocational', 'Phd']),
            'ownership_status' => $this->faker->randomElement(['Rent', 'Owned', 'Mortgage']),
            'work_duration' => fake()->numberBetween(0,5),
            'job_tenure' => fake()->numberBetween(0,3),
            /* 'tin_number' => $this->faker->phoneNumber(), */
           /*  'client_type' => $this->faker->randomElement(['Individual', 'Business']), */
            /* 'client_status' => 'Verified', */
        ];
    }
}
