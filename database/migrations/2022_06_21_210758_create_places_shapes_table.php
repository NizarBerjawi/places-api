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
            $table->string('country_code')->primary();
            $table->json('geometry');
        });

        Schema::table('places_shapes', function (Blueprint $table) {
            $table->foreign('country_code')->references('iso3166_alpha2')->on('countries')->cascadeOnDelete();
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
            $table->dropForeign(['country_code']);
        });
        Schema::dropIfExists('places_shapes');
    }
}
