<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountryCurrencyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('country_currency', function (Blueprint $table) {
            $table->string('country_code');
            $table->string('currency_code');
            $table->timestamps();
        });
        
        Schema::table('country_currency', function (Blueprint $table) {
            $table->primary(['country_code', 'currency_code']);
            $table->foreign('country_code')->references('iso3166_alpha2')->on('countries')->onCascade('delete');
            $table->foreign('currency_code')->references('code')->on('currencies')->onCascade('delete');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('countries', function (Blueprint $table) {
            $table->dropForeign(['country_code']);
            $table->dropForeign(['currency_code']);
        });

        Schema::dropIfExists('country_currency');
    }
}
