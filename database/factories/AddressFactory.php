<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
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
            'client_id'=> Client::factory(),
            'address_line_1'=> fake()->streetAddress(),
            'address_line_2'=> fake()->streetAddress(),
            'city'=> fake()->city(),
            'province'=> fake()->city(),
            'postal_code'=> fake()->postcode(),
        ];
    }
}
