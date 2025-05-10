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
                ['name' => 'client_name', 'label' => 'Client Name', 'type' => 'select', 'required' => true],
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
        ContractTemplate::create([
            'name' => 'Employment Agreement',
            'slug' => 'employment-agreement',
            'fields' => [
                ['name' => 'employee_name', 'label' => 'Employee Name', 'type' => 'select', 'required' => true],
                ['name' => 'position', 'label' => 'Position', 'type' => 'text', 'required' => true],
                ['name' => 'department', 'label' => 'Department', 'type' => 'text', 'required' => true],
                ['name' => 'start_date', 'label' => 'Start Date', 'type' => 'date', 'required' => true],
                ['name' => 'end_date', 'label' => 'End Date', 'type' => 'date', 'required' => false],
                ['name' => 'salary', 'label' => 'Monthly Salary', 'type' => 'number', 'required' => true],
            ],
            'content' => file_get_contents(resource_path('views/admin/contracts/employee-agreement.blade.php')), // Optional if using view files
        ]);
        ContractTemplate::create([
            'name' => 'Vendor Agreement',
            'slug' => 'vendor-agreement',
            'fields' => [
                ['name' => 'vendor_name', 'label' => 'Vendor Name', 'type' => 'text', 'required' => true],
                ['name' => 'service_description', 'label' => 'Service Description', 'type' => 'text', 'required' => true],
                ['name' => 'start_date', 'label' => 'Start Date', 'type' => 'date', 'required' => true],
                ['name' => 'end_date', 'label' => 'End Date', 'type' => 'date', 'required' => false],
                ['name' => 'service_fee', 'label' => 'Service Fee', 'type' => 'number', 'required' => true],
            ],
            'content' => file_get_contents(resource_path('views/admin/contracts/vendor-agreement.blade.php')), // Optional if using view files
        ]);

        ContractTemplate::create([
            'name' => 'Government Agreement',
            'slug' => 'government-agreement',
            'fields' => [
                ['name' => 'government_agency', 'label' => 'Government Agency', 'type' => 'text', 'required' => true],
                ['name' => 'project_title', 'label' => 'Project Title', 'type' => 'text', 'required' => true],
                ['name' => 'start_date', 'label' => 'Start Date', 'type' => 'date', 'required' => true],
                ['name' => 'end_date', 'label' => 'End Date', 'type' => 'date', 'required' => false],
                ['name' => 'budget', 'label' => 'Project Budget', 'type' => 'number', 'required' => true],
            ],
            'content' => file_get_contents(resource_path('views/admin/contracts/government-agreement.blade.php')), // Optional if using view files
        ]);
        
        
    }
}
