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
            'document_type'=> fake()->sentence(2),  
            'document_path'=> fake()->filePath(),    
            'document_status'=> fake()->randomElement(['pending','approved','rejected']),
            'submission_date'=> SupportCarbon::now()->format('Y-m-d'),
            'approval_date'=> SupportCarbon::now()->addDays(12)->format('Y-m-d'),
            'remarks'=>fake()->sentence(3),
        ];
    }
}
