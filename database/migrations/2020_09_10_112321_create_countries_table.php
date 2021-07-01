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
            $table->string('iso3166_alpha2', 2)->primary();
            $table->string('iso3166_alpha3', 3)->unique();
            $table->smallInteger('iso3166_numeric')->unique();
            $table->string('name', 255);
            $table->unsignedBigInteger('population');
            $table->unsignedDouble('area');
            $table->string('phone_code')->nullable();
            $table->string('continent_code');
        });

        Schema::table('countries', function (Blueprint $table) {
            $table->foreign('continent_code')->references('code')->on('continents')->onCascade('delete');
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
