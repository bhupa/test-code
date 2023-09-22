<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique()->nullable();
            $table->integer('country_code')->nullable();
            $table->string('phone')->nullable();
            $table->string('password')->nullable();
            $table->string('google_id')->nullable();
            $table->string('facebook_id')->nullable();
            $table->string('apple_id')->nullable();
            $table->timestamp('account_verified_at')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            // need to change defautl enum from laravel
            $table->string('device_token')->nullable();
            $table->string('verification_token')->nullable();
            $table->integer('user_type'); // user_type 1 = jobseeker, 2 = employee
            $table->integer('status'); // 1 = active, 2 = deactivated, 3 = bloked
            $table->rememberToken();
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
