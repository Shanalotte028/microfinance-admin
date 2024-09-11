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
            $table->foreignIdFor(Client::class);
            $table->decimal('total_loan_amount_borrowed',15,2)->default(0);
            $table->enum('loan_repayment_status', ['on-time','overdue','deliquent']);
            $table->decimal('income',15,2)->default(0); // Verified or self-reported income.
            $table->integer('credit_score')->default(0);
            $table->timestamps();
        });

        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Financial::class);
            $table->decimal('loan_amount',15,2)->default(0);
            $table->enum('loan_status', ['active','closed','defaulted']); //Current status of the loan.
            $table->decimal('interest_rate',5,2)->default(0);
            $table->date('start_date');
            $table->date('end_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financials');
        Schema::dropIfExists('loans');
    }
};
