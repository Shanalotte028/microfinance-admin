<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'employee_id' => 'EMP-' . now()->year . str_pad($this->faker->unique()->numberBetween(1, 9999), 4, '0', STR_PAD_LEFT),
            'first_name' => fake()->randomElement([
                'Juan', 'Jose', 'Rizal', 'Andres', 'Emilio', 'Manuel', 'Antonio', 'Fernando', 'Ramon', 'Carlos',
                'Maria', 'Isabel', 'Cristina', 'Josefina', 'Luz', 'Ligaya', 'Rosa', 'Corazon', 'Pilar', 'Teresa'
            ]),
            'last_name' => fake()->randomElement([
                'Dela Cruz', 'Santos', 'Reyes', 'Gonzales', 'Mendoza', 'Torres', 'Cruz', 'Garcia', 'Lopez', 'Ramos'
            ]),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'role' => $this->faker->randomElement(['Admin', 'Lawyer', 'Staff', 'Staff Manager', 'Field Investigator']),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
