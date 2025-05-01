<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('father_name');
            $table->string('phone_number');
            $table->string('father_profession');
            $table->string('previous_school');
            $table->enum('gender', ['male', 'female']);
            $table->string('session');
            $table->string('previous_class');
            $table->integer('marks');
            $table->string('desired_class');
            $table->string('catagory');
            $table->string('current_year'); // Added current_year column
            $table->text('address');
            $table->text('source');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('students');
    }
};
