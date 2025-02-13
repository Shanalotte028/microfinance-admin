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
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // The user who performed the action
            $table->string('action'); // The type of action performed
            $table->string('module'); // The module where the action was performed
            $table->text('description')->nullable(); // Additional details
            $table->ipAddress('ip_address')->nullable(); // IP address of the user
            $table->json('old_data')->nullable(); // Stores previous values before changes
            $table->json('new_data')->nullable(); // Stores new values after changes
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
