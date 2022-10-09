<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('forecast')->nullable();
            $table->string('temperature')->nullable();
            $table->string('feels_like')->nullable();
            $table->string('temp_min')->nullable();
            $table->string('temp_max')->nullable();
            $table->string('pressure')->nullable();
            $table->string('humidity')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cities');
    }
};
