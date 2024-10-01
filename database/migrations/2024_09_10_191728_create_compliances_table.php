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
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compliance_records');
    }
};
