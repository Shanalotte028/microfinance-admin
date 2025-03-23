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
            'employee_id' => 'EMP-20240001',
            'first_name' => 'Mark',
            'last_name' => 'Alde',
            'email' => 'aldemark28@gmail.com',
            'role' => 'Admin',
            'status' => 'active',
            'password' => 'adminadmin1234',
            'password_reset_required' => false,
        ]);

        $user2 = User::create([
            'employee_id' => 'EMP-20240002',
            'first_name' => 'Kram',
            'last_name' => 'Trash',
            'email' => 'kramtrash@gmail.com',
            'role' => 'Staff',
            'status' => 'active',
            'password' => 'adminadmin1234',
            'password_reset_required' => false,
        ]);

        $user3 = User::create([
            'employee_id' => 'EMP-20240003',
            'first_name' => 'Marky',
            'last_name' => 'Alde',
            'email' => 'aldemarkangelobsit1147@gmail.com',
            'role' => 'Lawyer',
            'status' => 'active',
            'password' => 'adminadmin1234',
            'password_reset_required' => false,
        ]);

        $user4 = User::create([
            'employee_id' => 'EMP-20240004',
            'first_name' => 'Marky',
            'last_name' => 'Alde',
            'email' => 'markangelo.alde028@gmail.com',
            'role' => 'Staff Manager',
            'status' => 'active',
            'password' => 'adminadmin1234',
            'password_reset_required' => false,
        ]);

        $user->assignRole('Admin'); // Assign role after creation
        $user2->assignRole('Staff');
        $user3->assignRole('Lawyer');
        $user4->assignRole('Staff Manager');
        

        // Create a specific client
     /*    Client::create([
            'client_id' => 101,
            'first_name' => 'Kram',
            'last_name' => 'Trash',
            'email' => 'kramtrash@gmail.com',
            /* 'client_type' => 'Individual', */
            /* 'password' => 'adminadmin1234',
        ]); */
        
        // Pre-create a set of lawyers (to avoid creating a new one for each case)
        $lawyers = User::factory()->count(10)->create(['role' => 'Lawyer']);

        // Create 100 clients with related records
        Client::factory()
            ->count(100)
            ->has(Address::factory(), 'address') // 1 Address per Client
            ->has(
                Financial::factory()
                    ->has(Loan::factory()->count(3), 'loans') // 3 Loans per Financial
                    ->afterCreating(function (Financial $financial) {
                        // Calculate total loan amount before saving
                        $financial->total_loan_amount_borrowed = $financial->loans->sum('principal_amount');
                        $financial->save();
                    }),
                'financial_details'
            )
            ->has(Compliance::factory()->count(2), 'compliance_records') // 2 Compliance records per Client
            ->has(Risk::factory()->count(2), 'risk_assessments') // 2 Risk assessments per Client
            ->has(
                LegalCase::factory()
                    ->count(3)
                    ->state(fn () => ['assigned_to' => $lawyers->random()->id]), // Assign a random lawyer
                'legalCases'
            )
            ->create();
    }
}