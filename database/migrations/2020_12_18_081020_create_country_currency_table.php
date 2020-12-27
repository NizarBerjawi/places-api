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
            $table->id();
            $table->unsignedBigInteger('country_id');
            $table->unsignedBigInteger('currency_id');
            $table->timestamps();
        });
        
        Schema::table('country_currency', function (Blueprint $table) {
            $table->foreign('country_id')->references('id')->on('countries')->onCascade('delete');
            $table->foreign('currency_id')->references('id')->on('currencies')->onCascade('delete');
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
            $table->dropForeign(['country_id']);
            $table->dropForeign(['currency_id']);
        });

        Schema::dropIfExists('country_currency');
    }
}
