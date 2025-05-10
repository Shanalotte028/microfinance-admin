<?php

namespace Database\Seeders;

use App\Models\ContractTemplate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContractTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ContractTemplate::create([
            'name' => ' Loan Agreement',
            'slug' => 'loan-agreement',
            'fields' => [
                ['name' => 'client_name', 'label' => 'Client Name', 'type' => 'text', 'required' => true],
                ['name' => 'submitted_at', 'label' => 'Submission Date', 'type' => 'date', 'required' => true],
                ['name' => 'principal_amount', 'label' => 'Principal Amount', 'type' => 'number', 'required' => true],
                ['name' => 'interest_rate', 'label' => 'Interest Rate (%)', 'type' => 'number', 'required' => true],
                ['name' => 'loan_term', 'label' => 'Loan Term', 'type' => 'number', 'required' => true],
                ['name' => 'term_type', 'label' => 'Term Type', 'type' => 'text', 'required' => true],
                ['name' => 'payment_frequency_method', 'label' => 'Payment Frequency', 'type' => 'text', 'required' => true],
                ['name' => 'installment', 'label' => 'Installment Amount', 'type' => 'number', 'required' => true],
                ['name' => 'end_date', 'label' => 'End Date', 'type' => 'date', 'required' => false],
                ['name' => 'loan_description', 'label' => 'Loan Description / Terms', 'type' => 'textarea', 'required' => false],
            ],
            'content' => file_get_contents(resource_path('views/admin/contracts/loan-agreement.blade.php')), // Optional if using view files
        ]);
        
    }
}
