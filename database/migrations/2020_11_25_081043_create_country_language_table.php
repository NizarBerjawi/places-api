<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountryLanguageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('country_language', function (Blueprint $table) {
            $table->unsignedBigInteger('country_id');
            $table->unsignedBigInteger('language_id');
            $table->timestamps();
        });

        Schema::table('country_language', function (Blueprint $table) {
            $table->primary(['country_id', 'language_id']);
            $table->foreign('country_id')->references('geoname_id')->on('countries')->onCascade('delete');
            $table->foreign('language_id')->references('id')->on('languages')->onCascade('delete');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('country_language', function (Blueprint $table) {
            $table->dropForeign(['country_id']);
            $table->dropForeign(['language_id']);
        });

        Schema::dropIfExists('country_language');
    }
}
