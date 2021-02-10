<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitiesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('city', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedInteger('okrug_id');
            $table->unsignedInteger('region_id');
            $table->unsignedInteger('population')->nullable();
            $table->year('started_at')->nullable();
            $table->point('coordinate')->nullable();
            $table->polygon('polygon')->nullable();
            $table->string('gerb')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('city_okrug', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('city_region', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('city');
        Schema::dropIfExists('city_okrug');
        Schema::dropIfExists('city_region');
    }
}
