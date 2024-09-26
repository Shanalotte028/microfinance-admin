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
            $table->string('first_name');
            $table->string('last_name');
            $table->string('password')->nullable();
            $table->string('email');
            $table->string('phone_number');
            $table->date('birthday');
            $table->enum('gender', ['Male','Female','Other']);
            $table->enum('client_type', ['Individual','Business']);
            $table->enum('client_status', ['Active','Inactive','Suspended','Closed'])->nullable();
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
            $table->foreignId('client_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Client::class);
            $table->string('address_line_1'); // Primary street address.
            $table->string('address_line_2'); // Additional address info (e.g., apartment number).
            $table->string('city');
            $table->string('province');
            $table->string('postal_code');
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
