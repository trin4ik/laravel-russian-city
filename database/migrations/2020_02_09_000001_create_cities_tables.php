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
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
            $table->unsignedInteger('okrug_id')->index();
            $table->unsignedInteger('region_id')->index();
            $table->unsignedInteger('population')->nullable();
            $table->unsignedSmallInteger('started_at')->nullable();
            $table->point('coordinate')->nullable();
            $table->polygon('polygon')->nullable();
            $table->string('gerb')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('city_okrugs', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
            $table->timestamps();
        });

        Schema::create('city_regions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
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
        Schema::dropIfExists('cities');
        Schema::dropIfExists('city_okrugs');
        Schema::dropIfExists('city_regions');
    }
}
