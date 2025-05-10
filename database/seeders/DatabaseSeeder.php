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
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            RolesAndPermissionsSeeder::class,
            ContractTemplateSeeder::class,
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

        $user5 = User::create([
            'employee_id' => 'EMP-20240005',
            'first_name' => 'Syno',
            'last_name' => 'Pzio',
            'email' => 'synopzio@gmail.com',
            'role' => 'Field Officer',
            'status' => 'active',
            'password' => 'adminadmin1234',
            'password_reset_required' => false,
        ]);

        $user6 = User::create([
            'employee_id' => 'EMP-20240006',
            'first_name' => 'Mark',
            'last_name' => 'Mark',
            'email' => 'markmark@gmail.com',
            'role' => 'Field Officer',
            'status' => 'active',
            'password' => 'adminadmin1234',
            'password_reset_required' => false,
        ]);

        $user->assignRole('Admin'); // Assign role after creation
        $user2->assignRole('Staff');
        $user3->assignRole('Lawyer');
        $user4->assignRole('Staff Manager');
        $user5->assignRole('Field Officer');
        $user6->assignRole('Field Officer');

        

       
        
        
        // Pre-create a set of lawyers (to avoid creating a new one for each case)
        $lawyers = User::factory()->count(3)->create(['role' => 'Lawyer']);
        $field_officers = User::factory()->count(3)->create(['role' => 'Field Officer']);
        
        //individual client
        $client = Client::create([
            'client_id' => 101,
            'first_name' => 'Kram',
            'last_name' => 'Trash',
            'email' => 'kramtrash@gmail.com',
            'password' => Hash::make('adminadmin1234'),
        ]);
        
        $client->address()->save(Address::factory()->make());
        
        $financial = Financial::factory()->create(['client_id' => $client->id]);
        
        $loans = Loan::factory()->count(3)->create(['financial_id' => $financial->id]);
        
        $financial->update([
            'total_loan_amount_borrowed' => $loans->sum('principal_amount'),
        ]);
        
        $client->compliance_records()->saveMany(Compliance::factory()->count(2)->make());
        $client->risk_assessments()->saveMany(Risk::factory()->count(3)->make());
        
        $client->legalCases()->save(
            LegalCase::factory()->make(['assigned_to' => $lawyers->random()->id])
        );
        
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
        ->has(Risk::factory()->count(3), 'risk_assessments') // Randomly 0-2 Risk assessments per Client
        ->has(
            LegalCase::factory()
                ->count(1) // Randomly 0-2 Legal Cases per Client
                ->state(fn () => ['assigned_to' => $lawyers->random()->id]), // Assign a random lawyer
            'legalCases'
        )
        ->create();

    }
}