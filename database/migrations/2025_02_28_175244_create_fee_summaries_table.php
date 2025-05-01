<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('fee_summaries', function (Blueprint $table) {
            $table->id();
            $table->string('class');
            $table->string('month_year');
            $table->integer('full_paid')->default(0);
            $table->integer('half_paid')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('fee_summaries');
    }
};
