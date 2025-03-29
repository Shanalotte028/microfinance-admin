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
        $permanentAddress = [
            'region' => $this->faker->randomElement(['I', 'II', 'III', 'IV-A', 'V', 'CAR', 'NCR', 'Mimaropa']),
            'province' => $this->faker->randomElement(['Metro Manila', 'Abra', 'Zambales', 'Quezon', 'Palawan', 'Nueva Ecija', 'Masbate', 'Marinduque']),
            'city'=> $this->faker->randomElement(['Quezon City', 'Caloocan City', 'Davao City', 'Taguig', 'Manila', 'Zamboanga', 'Cebu City', 'Antipolo']),
            'barangay' => fake()->numberBetween(1,250),
            'postal_code'=> fake()->postcode(),
            'street' => fake()->streetAddress(),
        ];
        
        // Decide if present address is the same as permanent
        $sameAddress = $this->faker->randomElement(['Yes', 'No']);
        
        $presentAddress = ($sameAddress === 'Yes') ? $permanentAddress : [
            'region' => $this->faker->randomElement(['I', 'II', 'III', 'IV-A', 'V', 'CAR', 'NCR', 'Mimaropa']),
            'province' => $this->faker->randomElement(['Metro Manila', 'Abra', 'Zambales', 'Quezon', 'Palawan', 'Nueva Ecija', 'Masbate', 'Marinduque']),
            'city'=> $this->faker->randomElement(['Quezon City', 'Caloocan City', 'Davao City', 'Taguig', 'Manila', 'Zamboanga', 'Cebu City', 'Antipolo']),
            'barangay' => fake()->numberBetween(1,250),
            'postal_code'=> fake()->postcode(),
            'street' => fake()->randomElement([
            'Rizal Street', 'Bonifacio Street', 'Mabini Street', 'Del Pilar Street',
            'Luna Street', 'Burgos Street', 'Quezon Avenue', 'Aguinaldo Street',
            'Osmeña Street', 'España Boulevard', 'San Juan Street', 'San Jose Street',
            'San Pedro Street', 'Santo Niño Street', 'Commonwealth Avenue', 'EDSA',
            'Taft Avenue', 'Ayala Avenue', 'Roxas Boulevard'
        ]) . ', ' . fake()->buildingNumber(),
        ];

        return [
            //
        'region' => $permanentAddress['region'],
        'province' => $permanentAddress['province'],
        'city' => $permanentAddress['city'],
        'barangay' => $permanentAddress['barangay'],
        'postal_code' => $permanentAddress['postal_code'],
        'permanent_street' => $permanentAddress['street'],

        'same_address' => $sameAddress,

        'present_region' => $presentAddress['region'],
        'present_province' => $presentAddress['province'],
        'present_city' => $presentAddress['city'],
        'present_barangay' => $presentAddress['barangay'],
        'present_postal_code' => $presentAddress['postal_code'],
        'present_street' => $presentAddress['street'],
            
        ];
    }
}
