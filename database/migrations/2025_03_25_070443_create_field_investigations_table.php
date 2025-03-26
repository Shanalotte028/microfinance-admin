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
        Schema::create('field_investigations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->foreignId('officer_id')->nullable()->default(null)->constrained('users')->onDelete('cascade'); // Field officer
            $table->text('observations')->nullable(); // Officer’s notes
            $table->boolean('verified')->nullable()->default(false); // Verified or not
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('field_investigations');
    }
};
