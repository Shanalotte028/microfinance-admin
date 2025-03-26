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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->integer('client_id');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('password')->nullable();
            $table->string('email')->nullable();
            $table->string('phone_number')->nullable();
            $table->date('birthday')->nullable();
            $table->enum('gender', ['Male','Female','Other'])->nullable();
            $table->string('marital_status')->nullable();
            $table->string('source_of_income')->nullable();
            $table->string('place_of_birth')->nullable();
            $table->integer('number_of_dependents')->nullable();
            $table->string('job_temporary')->nullable();
            $table->string('education_level')->nullable();
            $table->string('ownership_status')->nullable();
            $table->integer('work_duration')->nullable();
            $table->integer('job_tenure')->nullable();
             /* $table->string('nationality')->nullable(); */
            /* $table->string('tin_number')->nullable(); */
            /* $table->enum('client_type', ['Individual','Business'])->nullable();
            $table->enum('client_status', ['Verified','Unverified'])->default('Unverified'); */
           /*  $table->string('blocked')->default('No'); */
            $table->rememberToken()->nullable();
            $table->timestamps();
        });

        Schema::create('client_password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('client_sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Client::class)->constrained()->onDelete('cascade');
            $table->string('region'); 
            $table->string('province'); 
            $table->string('city');  
            $table->string('barangay');  
            $table->string('permanent_street');  
            $table->string('postal_code');
            $table->string('same_address');
            $table->string('present_region'); 
            $table->string('present_province'); 
            $table->string('present_city');  
            $table->string('present_barangay');  
            $table->string('present_street');  
            $table->string('present_postal_code');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
        Schema::dropIfExists('addresses');
    }
};
