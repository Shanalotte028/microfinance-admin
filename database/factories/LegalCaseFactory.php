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
            'title' => fake()->randomElement([
            'Breach of Contract Case',
            'Property Dispute Resolution',
            'Labor Complaint Against Employer',
            'Cyber Libel Case',
            'Custody Battle for Minor Child',
            'Land Title Ownership Claim',
            'Unlawful Dismissal Case',
            'Intellectual Property Violation',
            'Estate Inheritance Dispute',
            'Debt Collection Lawsuit'
        ]),
        'description' => fake()->randomElement([
            'The plaintiff alleges that the defendant failed to fulfill contractual obligations as per the agreement signed on a specified date. The case involves financial damages and legal remedies under Philippine contract law.',
            'A long-standing property boundary dispute between two families has escalated into a legal claim for rightful ownership. The court is set to determine the validity of land titles and related documents.',
            'An employee has filed a case against their former employer for wrongful termination without just cause. The case is being heard under the Philippine Labor Code.',
            'The complainant claims that defamatory statements were posted against them on social media, damaging their reputation. The case is being pursued under the Cybercrime Prevention Act.',
            'A custody battle has emerged between separated parents over the legal guardianship of their minor child. The court will decide based on the best interest of the child principle.',
            'The petitioner asserts that they have legal rights over a piece of land currently occupied by the respondent. The case involves reviewing tax declarations, land surveys, and title records.',
            'An employee is suing their employer for unfair labor practices, including salary deductions without consent and withholding of final pay. The case has been filed before the Department of Labor and Employment.',
            'A local business owner is suing another company for unauthorized use of their copyrighted materials. The case will determine damages and potential cease-and-desist orders.',
            'Heirs of a deceased individual are in dispute over the distribution of assets listed in the last will and testament. The case involves probate proceedings and estate division.',
            'A financial institution has taken legal action against a borrower for failure to repay a loan despite repeated demands. The case seeks to enforce debt recovery through legal channels.'
        ]),
            'status' => $this->faker->randomElement(['open', 'in_progress', 'closed']), // Random status
            'filing_date' => $this->faker->date(), // Random filing date
            'closing_date' => $this->faker->optional()->date(), // Random closing date (nullable)
        ];
    }
}
