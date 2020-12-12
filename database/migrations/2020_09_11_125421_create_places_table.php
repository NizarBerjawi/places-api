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
            $table->id();
            $table->string('name');
            $table->integer('population')->nullable();
            $table->string('elevation')->nullable();
            $table->unsignedBigInteger('feature_code_id')->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->timestamps();
        });

        Schema::table('places', function (Blueprint $table) {
            $table->foreign('feature_code_id')->references('id')->on('feature_codes')->onCascade('delete');
            $table->foreign('country_id')->references('id')->on('countries')->onCascade('delete');
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
            $table->dropForeign(['feature_code_id']);
            $table->dropForeign(['country_id']);
        });
        Schema::dropIfExists('places');
    }
}
