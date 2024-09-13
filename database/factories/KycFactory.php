<?php

namespace Database\Factories;

use App\Models\Compliance;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Kyc>
 */
class KycFactory extends Factory
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
            'compliance_id' => Compliance::factory(), // Foreign key for Compliance
            'document_type' => $this->faker->randomElement(['Passport', 'Utility Bill', 'Driver License']), // Random document type
            'document_path' => $this->faker->filePath(), // Random file path
            'verification_status' => 'pending', // Random verification status
            'uploaded_at' => $this->faker->dateTime(), // Random uploaded date
            'verified_at' => null, // Random verification date (nullable)
            'verified_by' => null // Random staff ID (nullable)
        ];
    }
}
