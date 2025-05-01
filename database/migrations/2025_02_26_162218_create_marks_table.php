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
        Schema::create('marks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->string('week'); // e.g., "Week 1", "Week 2"
            $table->integer('month'); // e.g., 1 for January, 2 for February
            $table->string('year'); // e.g., 2024
            
            // Change subject fields to VARCHAR to store "obtained/total" format
            $table->string('Biology', 10)->nullable();
            $table->string('Chemistry', 10)->nullable();
            $table->string('Math', 10)->nullable();
            $table->string('Computer', 10)->nullable();
            $table->string('Physics', 10)->nullable();
            $table->string('English', 10)->nullable();
            $table->string('Urdu', 10)->nullable();
            $table->string('Islamiat', 10)->nullable();
            $table->string('Pakstudy', 10)->nullable();
            $table->string('Economics', 10)->nullable();
            $table->string('Healthphysicaledication', 10)->nullable();
            $table->string('Sociology', 10)->nullable();
            
            $table->timestamps();

            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('marks');
    }
};
