<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('places', function (Blueprint $table) {
            $table->id('geoname_id');
            $table->string('name');
            $table->string('ascii_name')->index()->nullable();
            $table->unsignedBigInteger('population')->index()->nullable();
            $table->smallInteger('elevation')->index()->nullable();
            $table->smallInteger('dem')->index()->nullable();
            $table->string('feature_code')->index()->nullable();
            $table->string('country_code')->index()->nullable();
            $table->string('time_zone_code')->index()->nullable();
        });

        Schema::table('places', function (Blueprint $table) {
            $table->foreign('feature_code')->references('code')->on('feature_codes')->cascadeOnDelete();
            $table->foreign('country_code')->references('iso3166_alpha2')->on('countries')->cascadeOnDelete();
            $table->foreign('time_zone_code')->references('code')->on('time_zones')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('places', function (Blueprint $table) {
            $table->dropForeign(['feature_code']);
            $table->dropForeign(['country_code']);
            $table->dropForeign(['time_zone_code']);
        });

        Schema::dropIfExists('places');
    }
}
