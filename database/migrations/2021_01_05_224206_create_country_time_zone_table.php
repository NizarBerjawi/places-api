<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountryTimeZoneTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('country_time_zone', function (Blueprint $table) {
            $table->unsignedBigInteger('time_zone_id');
            $table->unsignedBigInteger('country_id');
            $table->timestamps();
        });

        Schema::table('country_time_zone', function (Blueprint $table) {
            $table->primary(['time_zone_id', 'country_id']);
            $table->foreign('country_id')->references('geoname_id')->on('countries')->onCascade('delete');
            $table->foreign('time_zone_id')->references('id')->on('time_zones')->onCascade('delete');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('country_time_zone', function (Blueprint $table) {
            $table->dropForeign(['time_zone_id']);
            $table->dropForeign(['country_id']);
        });

        Schema::dropIfExists('country_time_zone');
    }
}
