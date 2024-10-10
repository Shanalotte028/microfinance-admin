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
        User::create([
        'first_name' => 'Mark',
        'last_name' => 'Alde',
        'email' => 'aldemark28@gmail.com',
        'role' => 'admin',
        'access_level' => 'Admin',
        'password' => 'adminadmin1234',
        ]);

        Client::create([
        'first_name'=> 'Kram',
        'last_name' => 'Trash',
        'email' => 'kramtrash@gmail.com',
        'phone_number' => '09103475330',
        'birthday' => '2001-11-28',
        'gender' => 'Male',
        'nationality' => 'Filipino',
        'marital_status' => 'Single',
        'source_of_income' => 'Employment Income',
        'tin_number' => '123456789101',
        'client_type' => 'Individual',
        'client_status' => 'Unverified',
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

                // Seed risk assessments for each client
                Risk::factory()
                    ->count(2) // 2 risk assessments per client
                    ->create(['client_id' => $client->id]);
            });
    }
}
