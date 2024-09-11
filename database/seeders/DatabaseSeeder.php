<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Compliance;
use App\Models\Risk;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create 100 clients with associated risks and compliances
        Client::factory(100)->create()->each(function ($client) {
            // Create risks for each client
            Risk::factory(1)->create(['client_id' => $client->id]);

            // Create compliances for each client
            Compliance::factory(1)->create(['client_id' => $client->id]);
        });
    }
}
