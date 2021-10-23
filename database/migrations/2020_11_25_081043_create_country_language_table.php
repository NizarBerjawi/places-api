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
            $table->string('language_code');
        });

        Schema::table('country_language', function (Blueprint $table) {
            $table->primary(['country_code', 'language_code']);
            $table->foreign('country_code')->references('iso3166_alpha2')->on('countries')->cascadeOnDelete();
            $table->foreign('language_code')->references('iso639_3')->on('languages')->cascadeOnDelete();
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
            $table->dropForeign(['language_code']);
        });

        Schema::dropIfExists('country_language');
    }
}
