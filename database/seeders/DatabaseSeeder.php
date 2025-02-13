<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Client;
use App\Models\Compliance;
use App\Models\Financial;
use App\Models\LegalCase;
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

        $this->call([
            RolesAndPermissionsSeeder::class,
        ]);
        // Create an admin user
        $user = User::create([
            'first_name' => 'Mark',
            'last_name' => 'Alde',
            'email' => 'aldemark28@gmail.com',
            'role' => 'Admin',
            'access_level' => 'Admin',
            'status' => 'active',
            'password' => 'adminadmin1234',
            'password_reset_required' => false,
        ]);

        $user2 = User::create([
            'first_name' => 'Kram',
            'last_name' => 'Trash',
            'email' => 'kramtrash@gmail.com',
            'role' => 'Staff',
            'access_level' => 'Staff',
            'status' => 'active',
            'password' => 'adminadmin1234',
            'password_reset_required' => false,
        ]);

        $user3 = User::create([
            'first_name' => 'Marky',
            'last_name' => 'Alde',
            'email' => 'aldemarkangelobsit1147@gmail.com',
            'role' => 'Lawyer',
            'access_level' => 'Lawyer',
            'status' => 'active',
            'password' => 'adminadmin1234',
            'password_reset_required' => false,
        ]);

        $user4 = User::create([
            'first_name' => 'Marky',
            'last_name' => 'Alde',
            'email' => 'markangelo.alde028@gmail.com',
            'role' => 'Staff Manager',
            'access_level' => 'Staff Manager',
            'status' => 'active',
            'password' => 'adminadmin1234',
            'password_reset_required' => false,
        ]);

        $user->assignRole('Admin'); // Assign role after creation
        $user2->assignRole('Staff');
        $user3->assignRole('Lawyer');
        $user4->assignRole('Staff Manager');
        

        // Create a specific client
        Client::create([
            'first_name' => 'Kram',
            'last_name' => 'Trash',
            'email' => 'kramtrash@gmail.com',
            'client_type' => 'Individual',
            'password' => 'adminadmin1234',
        ]);

        // Create 100 clients with related records
        Client::factory()
            ->count(100) // Creates 100 clients
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
                Compliance::factory()
                    ->count(2) // 2 compliance records per client
                    ->create(['client_id' => $client->id]);

                // Seed risk assessments for each client
                Risk::factory()
                    ->count(2) // 2 risk assessments per client
                    ->create(['client_id' => $client->id]);

                // Seed legal cases for each client
                LegalCase::factory()
                    ->count(3) // 3 legal cases per client
                    ->create([
                        'client_id' => $client->id,
                        'assigned_to' => User::factory()->create(['role' => 'Lawyer'])->id, // Assign a lawyer
                    ]);
            });
    }
}