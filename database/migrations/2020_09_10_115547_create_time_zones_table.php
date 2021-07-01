<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimeZonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('time_zones', function (Blueprint $table) {
            $table->string('time_zone')->primary();
            $table->string('country_code', 2);
            $table->float('gmt_offset', 4, 2);
        });

        Schema::table('time_zones', function (Blueprint $table) {
            $table->foreign('country_code')->references('iso3166_alpha2')->on('countries')->onCascade('delete');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('time_zones', function (Blueprint $table) {
            $table->dropForeign(['country_code']);
        });

        Schema::dropIfExists('time_zones');
    }
}
