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
        Schema::create('matching_payment', function (Blueprint $table) {
            $table->id();
            $table->json('stripe_response')->nullable();
            $table->unsignedBigInteger('matching_id');
            $table->foreign('matching_id')->references('id')->on('matching')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matching_payment');
    }
};
