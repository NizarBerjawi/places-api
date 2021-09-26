<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlternateNamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alternate_names', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('geoname_id');
            $table->unsignedBigInteger('language_id');
            $table->string('name');
            $table->boolean('is_preferred_name')->default(false);
            $table->boolean('is_short_name')->default(false);
        });

        Schema::table('alternate_names', function (Blueprint $table) {
            $table->foreign('geoname_id')->references('geoname_id')->on('places')->onCascade('delete');
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
        Schema::table('alternate_names', function (Blueprint $table) {
            $table->dropForeign(['geoname_id']);
            $table->dropForeign(['language_id']);
        });

        Schema::dropIfExists('alternate_names');
    }
}
