<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Client;
use App\Models\Compliance;
use App\Models\Financial;
use App\Models\Loan;
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
        Client::factory()
            ->count(10) // Creates 10 clients
            ->create()
            ->each(function ($client) {
                // Seed addresses for each client
                Address::factory()
                    ->count(1)
                    ->create(['client_id' => $client->id]);

                // Seed financial details for each client
                $financialDetails = Financial::factory()
                    ->create(['client_id' => $client->id]);

                // Seed loans for each financial record
                $loans = Loan::factory()
                    ->count(3) // 3 loans per financial record
                    ->create(['financial_id' => $financialDetails->id]);

                // Calculate and save total loan amount borrowed
                $totalLoanAmount = Loan::where('financial_id', $financialDetails->id)->sum('loan_amount');
                $financialDetails->total_loan_amount_borrowed = $totalLoanAmount;
                $financialDetails->save();

                // Seed compliance records for each client
                Compliance::factory()
                    ->count(2) // 2 compliance records per client
                    ->create(['client_id' => $client->id]);

                // Seed risk assessments for each client
                Risk::factory()
                    ->count(2) // 2 risk assessments per client
                    ->create(['client_id' => $client->id]);

                    echo "Creating client with ID: {$client->id}\n";

                    // Other operations...

                    // Debug foreign key assignments
                    echo "Address client_id: {$client->id}\n";
                    echo "Financial client_id: {$client->id}\n";
                    echo "Loans financial_id: {$financialDetails->id}\n";
                    echo "Compliance client_id: {$client->id}\n";
                    echo "Risk client_id: {$client->id}\n";
            });
    }
}
