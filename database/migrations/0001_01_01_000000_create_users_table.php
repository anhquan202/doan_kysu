<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('user_id')->primary();
            $table->string('first_name');
            $table->string('last_name')->unique();
            $table->string('phone_number')->nullable();
            $table->string('email');
            $table->string('address');
            $table->string('gender')->nullable()->default('other');
            $table->foreignId('user_status_id')->constrained('user_statuses', 'user_status_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
