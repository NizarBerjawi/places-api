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
            $table->id();
            $table->unsignedBigInteger('country_id');
            $table->unsignedBigInteger('neighbour_id');
            $table->timestamps();
        });

        Schema::table('country_neighbour', function (Blueprint $table) {
            $table->foreign('country_id')->references('id')->on('countries')->onCascade('delete');
            $table->foreign('neighbour_id')->references('id')->on('countries')->onCascade('delete');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('country_neighbour', function(Blueprint $table) {
            $table->dropForeign(['country_id']);
            $table->dropForeign(['neighbour_id']);
        });

        Schema::dropIfExists('country_neighbour');
    }
}
