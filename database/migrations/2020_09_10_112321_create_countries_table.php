<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('iso3166_alpha2')->unique();
            $table->string('iso3166_alpha3')->unique();
            $table->string('iso3166_numeric')->unique();
            $table->unsignedBigInteger('continent_id');
            $table->integer('population');
            $table->integer('area');
            $table->string('phone_code')->nullable();
            $table->timestamps();
        });

        Schema::table('countries', function (Blueprint $table) {
            $table->foreign('continent_id')->references('id')->on('continents')->onCascade('delete');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('countries', function (Blueprint $table) {
            $table->dropForeign(['continent_id']);
        });

        Schema::dropIfExists('countries');
    }
}
