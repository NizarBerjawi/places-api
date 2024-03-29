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
            $table->unsignedBigInteger('geoname_id')->index();
            $table->string('language_code');
            $table->string('name');
            $table->boolean('is_preferred_name')->default(false);
            $table->boolean('is_short_name')->default(false);
            $table->boolean('is_colloquial')->default(false);
            $table->boolean('is_historic')->default(false);
        });

        Schema::table('alternate_names', function (Blueprint $table) {
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
        Schema::table('alternate_names', function (Blueprint $table) {
            $table->dropForeign(['language_code']);
        });

        Schema::dropIfExists('alternate_names');
    }
}
