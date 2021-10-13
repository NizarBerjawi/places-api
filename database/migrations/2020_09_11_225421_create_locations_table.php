e<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->unsignedBigInteger('geoname_id')->primary();
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
        });

        Schema::table('locations', function (Blueprint $table) {
            $table->foreign('geoname_id')->references('geoname_id')->on('places')->onCascade('delete');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('locations');
    }
}
