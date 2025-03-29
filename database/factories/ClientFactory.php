<?php

namespace Database\Factories;

use App\Models\Client;
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
            'first_name' => fake()->randomElement([
                'Juan', 'Jose', 'Rizal', 'Andres', 'Emilio', 'Manuel', 'Antonio', 'Fernando', 'Ramon', 'Carlos',
                'Maria', 'Isabel', 'Cristina', 'Josefina', 'Luz', 'Ligaya', 'Rosa', 'Corazon', 'Pilar', 'Teresa'
            ]),
            'last_name' => fake()->randomElement([
                'Dela Cruz', 'Santos', 'Reyes', 'Gonzales', 'Mendoza', 'Torres', 'Cruz', 'Garcia', 'Lopez', 'Ramos'
            ]),
            'email' => fake()->unique()->safeEmail(),
            'phone_number' => '+63' . fake()->numerify('9#########'),
            'birthday' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'place_of_birth' => $this->faker->randomElement([
                'Quezon City', 'Caloocan City', 'Davao City', 'Taguig', 'Manila', 'Zamboanga', 'Cebu City', 'Antipolo'
            ]),
            'gender' => $this->faker->randomElement(['Male', 'Female', 'Other']),
            'marital_status' => $this->faker->randomElement(['Single', 'Married']),
            'source_of_income' => $this->faker->randomElement(['Employment Income', 'Business Income']),
            'number_of_dependents' => fake()->numberBetween(0, 5),
            
            // Education Level with lower probability for advanced degrees
            'education_level' => $this->getEducationLevel(),
        
            'ownership_status' => $this->faker->randomElement(['Rent', 'Owned', 'Mortgage']),
            
            // Job status
            'job_temporary' => $job_status = $this->faker->randomElement(['Employed', 'Self-Employed', 'Unemployed']),
            
            // Work duration & job tenure logic
            'work_duration' => $work_duration = fake()->numberBetween(0, 20),
            'job_tenure' => ($job_status === 'Unemployed') ? 0 : fake()->numberBetween(0, $work_duration),
        ];
    }

        /**
         * Get an education level with lower probability for PhD, Master, and Doctorate.
         *
         * @return string
         */
        private function getEducationLevel(): string
        {
            $random = fake()->numberBetween(1, 100);

            if ($random <= 5) {
                return 'PhD'; // 5% chance
            } elseif ($random <= 15) {
                return 'Doctorate'; // 10% chance
            } elseif ($random <= 30) {
                return 'Master'; // 15% chance
            } elseif ($random <= 50) {
                return 'Bachelor'; // 20% chance
            } elseif ($random <= 75) {
                return 'Vocational'; // 25% chance
            } else {
                return 'High School'; // 25% chance (most common)
            }
        }
}
