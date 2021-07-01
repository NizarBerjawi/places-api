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
            $table->string('country_code');
            $table->unsignedBigInteger('language_id');
        });

        Schema::table('country_language', function (Blueprint $table) {
            $table->primary(['country_code', 'language_id']);
            $table->foreign('country_code')->references('iso3166_alpha2')->on('countries')->onCascade('delete');
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
            $table->dropForeign(['country_code']);
            $table->dropForeign(['language_id']);
        });

        Schema::dropIfExists('country_language');
    }
}
