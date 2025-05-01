<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->string('desired_class')->nullable();
            $table->string('catagory')->nullable();
            $table->string('gender')->nullable();
            $table->date('attendance_date')->default(now()); // Default to today's date
            $table->string('month_year'); // Stores attendance month (YYYY-MM)
            $table->boolean('is_present')->default(0); // 1 for present, 0 for absent
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('attendances');
    }
};
