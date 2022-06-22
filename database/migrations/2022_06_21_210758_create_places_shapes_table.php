<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlacesShapesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('places_shapes', function (Blueprint $table) {
            $table->unsignedBigInteger('geoname_id')->primary();
            $table->json('geometry');
            $table->timestamps();
        });

        Schema::table('places_shapes', function (Blueprint $table) {
            $table->foreign('geoname_id')->references('geoname_id')->on('countries')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('places_shapes', function (Blueprint $table) {
            $table->dropForeign(['geoname_id']);
        });
        Schema::dropIfExists('places_shapes');
    }
}
