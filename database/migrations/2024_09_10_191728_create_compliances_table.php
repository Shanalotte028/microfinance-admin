<?php

use App\Models\Client;
use App\Models\Compliance;
use App\Models\User;
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
        Schema::create('compliance_records', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Client::class);
            $table->string('document_type');
            $table->enum('document_status', ['pending','approved','rejected']);
            $table->dateTime('submission_date');
            $table->dateTime('approval_date')->nullable(); // When the document was approved/rejected.
            $table->text('remarks')->nullable(); //Any additional comments or reasons for rejection.
            $table->timestamps();
        });

        Schema::create('kyc_records', function (Blueprint $table) {
            $table->id(); // Unique identifier for each KYC record
            $table->foreignIdFor(Compliance::class); // Foreign key reference to clients table
            $table->string('document_type', 100); // Type of KYC document (e.g., Passport)
            $table->string('document_path', 255); // File path or URL to the uploaded document
            $table->enum('verification_status', ['pending', 'verified', 'failed'])->default('pending'); // Status of verification
            $table->dateTime('uploaded_at'); // When the document was uploaded
            $table->dateTime('verified_at')->nullable(); // When the document was verified (nullable)
            $table->foreignId('verified_by')->nullable();// Staff's ID who verified the document (nullable)
            $table->timestamps(); // created_at and updated_at timestamps
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compliance_records');
        Schema::dropIfExists('kyc_records');
    }
};
