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
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('template_id')->constrained('contract_templates');
            $table->foreignId('compliance_record_id')->nullable()->constrained(); // Link to compliance
            /* $table->foreignId('legal_case_id')->nullable()->constrained(); */ // Link to legal cases
            $table->text('content');
            $table->json('terms')->nullable();
            $table->enum('status', ['draft', 'pending_signature', 'active', 'expired', 'terminated']);
            $table->string('title');
            /* 
            $table->date('start_date');
            $table->date('end_date');
            $table->boolean('auto_renew');
            $table->text('description');
            $table->string('signed_file_path')->nullable();  */ // Stores signed PDF
            $table->string('signing_token')->nullable()->unique();
            $table->timestamp('signing_expires_at')->nullable();
            $table->timestamp('signing_sent_at')->nullable();
            $table->timestamp('party_signed_at')->nullable();
            $table->text('signature_data')->nullable(); // SVG format
            $table->string('signer_ip')->nullable();
            $table->string('signer_user_agent')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
