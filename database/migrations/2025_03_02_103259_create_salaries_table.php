<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('salaries', function (Blueprint $table) {
            $table->id();
            $table->string('teacher_name');
            $table->decimal('final_payable', 10, 2); // Final salary of the month
            $table->string('salary_month'); // Stores salary for the respective month
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('salaries');
    }
};
