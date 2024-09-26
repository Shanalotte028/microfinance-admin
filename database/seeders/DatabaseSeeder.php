<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Client;
use App\Models\Compliance;
use App\Models\Financial;
use App\Models\Kyc;
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
        User::create([
        'first_name' => 'Mark',
        'last_name' => 'Alde',
        'email' => 'aldemark28@gmail.com',
        'role' => 'admin',
        'access_level' => 'admin',
        'password' => 'adminadmin1234',
        ]);

        Client::factory()
            ->count(100) // Creates 10 clients
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
                Loan::factory()
                    ->count(3) // 3 loans per financial record
                    ->create(['financial_id' => $financialDetails->id]);

                // Calculate and save total loan amount borrowed
                $totalLoanAmount = Loan::where('financial_id', $financialDetails->id)->sum('loan_amount');
                $financialDetails->total_loan_amount_borrowed = $totalLoanAmount;
                $financialDetails->save();

                // Seed compliance records for each client
                $compliances = Compliance::factory()
                    ->count(2) // 2 compliance records per client
                    ->create(['client_id' => $client->id]);

                $compliances->each(function ($compliance) {
                        Kyc::factory()
                            ->count(3)
                            ->create(['compliance_id' => $compliance->id]);
                    });

                // Seed risk assessments for each client
                Risk::factory()
                    ->count(2) // 2 risk assessments per client
                    ->create(['client_id' => $client->id]);
            });
    }
}
