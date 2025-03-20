<?php

use App\Models\Client;
use App\Models\Financial;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('financial_details', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Client::class)->constrained()->onDelete('cascade');;
            $table->decimal('total_loan_amount_borrowed', 15,2)->default(0)->nullable();
            /* $table->enum('loan_repayment_status', ['on-time','overdue','deliquent']); */
            $table->integer('late_payments')->default(0);
            $table->integer('loan_defaults')->default(0);
            $table->integer('number_of_payments')->default(0);
            $table->decimal('annual_income',15,2)->default(0); // Verified or self-reported income.
            $table->decimal('monthly_income',15,2)->default(0);
            $table->decimal('monthly_expenses',15,2)->default(0);
            $table->decimal('savings_account_balance',15,2)->default(0)->nullable();
            $table->decimal('checking_account_balance',15,2)->default(0)->nullable();
            $table->decimal('total_assets',15,2)->default(0)->nullable();
            $table->decimal('networth',15,2)->default(0)->nullable();
            $table->integer('credit_score')->default(0);
            $table->timestamps();
        });

        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Financial::class);
            $table->date('submitted_at');
            $table->decimal('principal_amount',15,2)->default(0);
            $table->enum('loan_status', ['pending','processing','approved', 'rejected', 'active', 'finished', 'default', 'review']); //Current status of the loan.
            $table->decimal('interest_rate',5,2)->default(0);
            $table->string('term_type');
            $table->integer('loan_term');
            $table->string('payment_frequency_method');
            $table->decimal('installment', 15, 2);
            $table->string('loan_description');
            /* $table->string('start_date'); */
            $table->date('end_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financial_details');
        Schema::dropIfExists('loans');
    }
};
