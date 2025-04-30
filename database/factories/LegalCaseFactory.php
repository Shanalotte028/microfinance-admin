<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class LegalCaseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'client_id' => Client::factory(), // Create a new client if not provided
            'assigned_to' => User::factory(), // Create a new user (lawyer) if not provided
            'case_number' => $this->faker->unique()->numerify('CASE-####'), // Unique case number
            'title' => $this->faker->randomElement([
                'Loan Agreement Dispute',
                'Delayed Repayment Issue',
                'Fraudulent Loan Application',
                'Breach of Contract in Microfinance Loan',
                'Unauthorized Loan Application',
                'Client Loan Default Litigation',
                'Microloan Settlement Negotiation',
                'Compliance Violation in Loan Disbursement',
                'Dispute Over Collateral Agreement',
                'Client Complaint on Loan Terms'
            ]),
            'description' => $this->faker->randomElement([
                'The client has raised concerns regarding an unexpected increase in interest rates, which was not clearly explained in the loan agreement.',
                'A legal complaint was filed regarding the misrepresentation of loan terms during the application process.',
                'The client has defaulted on multiple loan payments and is now facing legal action for repayment enforcement.',
                'A dispute has arisen between the client and the microfinance institution over the ownership of collateral submitted for loan security.',
                'There is an ongoing legal issue regarding unauthorized deductions from the client’s account related to loan repayment.',
                'The client claims that their loan application was fraudulently processed by a third party without their consent.',
                'A mediation is being arranged between the microfinance institution and the client for a settlement on overdue loan payments.',
                'The borrower has raised a dispute over hidden charges in the loan contract that were not disclosed at the time of signing.',
                'A client has accused the loan officer of unfairly rejecting a loan restructuring request despite meeting eligibility criteria.',
                'Legal proceedings have been initiated due to a client’s failure to adhere to the agreed repayment schedule, resulting in severe penalties.'
            ]),
            'status' => $this->faker->randomElement(['open', 'in_progress', 'closed']), // Random status
            'filing_date' => $this->faker->date('Y-m-d', $this->faker->dateTimeBetween('2020-01-01', '2025-12-31')),
            'closing_date' => $this->faker->optional()->date(), // Random closing date (nullable)
        ];
    }
}
