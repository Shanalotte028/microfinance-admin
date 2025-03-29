<?php

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
        Schema::create('pending_legal_cases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id');
            $table->foreignId('assigned_to')->nullable(); // Assigned lawyer (optional before approval)
            $table->string('case_number')->unique();
            $table->string('title');
            $table->date('filing_date');
            $table->text('description');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pending_legal_cases');
    }
};
