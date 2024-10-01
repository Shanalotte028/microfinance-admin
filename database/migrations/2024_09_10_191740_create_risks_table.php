<?php

use App\Models\Client;
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
        //Purpose: Store periodic risk assessments for clients.
        Schema::create('risk_assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Client::class)->constrained()->onDelete('cascade');;
            $table->integer('risk_score'); // Numerical score representing the client's risk.
            $table->enum('risk_level', ['low','medium','high']); // Categorized risk level.
            $table->string('recommendation'); //Suggested actions based on assessment (e.g., flag for review).
            $table->dateTime('assessment_date'); // Date of the assessment.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('risk_assessments');
    }
};
