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
        Schema::create('jobseekers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('first_name');
            $table->string('last_name')->nullable();
            // $table->string('image')->nullable();
            $table->datetime('birthday')->nullable();
            $table->string('country')->nullable();
            $table->string('current_country')->nullable();
            $table->string('gender'); // male = 1 , female = 2, binary = 3
            $table->string('occupation')->nullable();
            $table->string('experience')->nullable(); // less than 1 year = 1, less than 2 year =2, less than 3 year = 3, 3 or more = 4
            $table->string('japanese_level')->nullable(); // N1 = 1 , N2 = 2, N3 = 3, N4 = 4 , N5 =5
            // about should be change to description  for proper meaning
            $table->boolean('longterm')->nullable();
            $table->boolean('employment_status')->nullable();  // 1 parttime, 2 fulltime, 3 ssw, 4 internship
            $table->boolean('living_japan')->nullable();
            $table->boolean('ielts_six')->nullable();
            $table->boolean('visa')->nullable();
            $table->text('about')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobseekers');
    }
};
