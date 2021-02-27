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
            $table->string('time_zone_code');
            $table->string('country_code');
            $table->timestamps();
        });

        Schema::table('country_time_zone', function (Blueprint $table) {
            $table->primary(['time_zone_code', 'country_code']);
            $table->foreign('country_code')->references('iso3166_alpha2')->on('countries')->onCascade('delete');
            $table->foreign('time_zone_code')->references('code')->on('time_zones')->onCascade('delete');
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
            $table->dropForeign(['time_zone_code']);
            $table->dropForeign(['country_code']);
        });

        Schema::dropIfExists('country_time_zone');
    }
}
