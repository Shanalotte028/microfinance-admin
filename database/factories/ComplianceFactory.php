<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon as SupportCarbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Compliance>
 */
class ComplianceFactory extends Factory
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
            'compliance_type' => $this->faker->randomElement(['KYC','Other Compliance']),
            'document_type'=> $this->faker->randomElement(['ID Proof', 'Income Proof', 'Citizenship Proof']),
            'document_path'=> fake()->imageUrl($width = 640, $height = 480),    
            'document_status'=> 'pending',
            'submission_date'=> fake()->date(),
            'approval_date'=> null,
            'remarks'=> null,
        ];
    }
}
