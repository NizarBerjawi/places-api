<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountryNeighbourTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('country_neighbour', function (Blueprint $table) {
            $table->string('country_code');
            $table->string('neighbour_code');
            $table->timestamps();
        });

        Schema::table('country_neighbour', function (Blueprint $table) {
            $table->primary(['country_code', 'neighbour_code']);
            $table->foreign('country_code')->references('iso3166_alpha2')->on('countries')->onCascade('delete');
            $table->foreign('neighbour_code')->references('iso3166_alpha2')->on('countries')->onCascade('delete');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('country_neighbour', function (Blueprint $table) {
            $table->dropForeign(['country_code']);
            $table->dropForeign(['neighbour_code']);
        });

        Schema::dropIfExists('country_neighbour');
    }
}
