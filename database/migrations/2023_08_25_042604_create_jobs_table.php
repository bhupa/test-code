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
        if (Schema::hasTable('jobs')) {
            return;
        }
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->longText('job_title')->nullable();
            $table->integer('job_location');
            $table->float('salary_from')->nullable();
            $table->float('salary_to')->nullable();
            $table->integer('working_hours')->nullable();
            $table->integer('break_time')->nullable();
            $table->json('holidays')->nullable();
            $table->string('vacation')->nullable();
            $table->integer('age_from')->nullable();
            $table->integer('age_to')->nullable();
            $table->integer('gender')->nullable();
            // $table->integer('occupation')->nullable();
            $table->integer('experience')->nullable();
            $table->integer('japanese_level')->nullable();
            $table->longText('required_skills')->nullable();
            $table->datetime('published')->nullable();
            $table->datetime('from_when')->nullable();
            $table->boolean('experience_required')->nullable();
            $table->boolean('pay_raise')->nullable();
            $table->boolean('training')->nullable();
            $table->boolean('education')->nullable();
            $table->boolean('women_preferred')->nullable();
            $table->boolean('men_preferred')->nullable();
            $table->boolean('urgent_recruitment')->nullable();
            $table->boolean('social_insurance')->nullable();
            $table->boolean('english_required')->nullable();
            $table->boolean('accommodation')->nullable();
            $table->boolean('five_days_working')->nullable();
            $table->boolean('uniform_provided')->nullable();
            $table->boolean('station_chika')->nullable();
            $table->boolean('skill_up')->nullable();
            $table->boolean('big_company')->nullable();
            $table->boolean('employer_status')->nullable();
            // $table->boolean('part_time')->nullable();
            // $table->boolean('full_time')->nullable();
            // $table->boolean('ssw')->nullable();
            // $table->boolean('internship')->nullable();
            $table->boolean('temporary_staff')->nullable();
            $table->integer('status')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('occupation');
            $table->foreign('occupation')->references('id')->on('job_category')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('jobs')) {
            return;
        }
        Schema::dropIfExists('jobs');
    }
};
