<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeatureCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feature_codes', function (Blueprint $table) {
            $table->string('code')->primary();
            $table->text('short_description')->nullable();
            $table->text('full_description')->nullable();
            $table->string('feature_class_code');
            $table->timestamps();
        });

        Schema::table('feature_codes', function (Blueprint $table) {
            $table->foreign('feature_class_code')->references('code')->on('feature_classes')->onCascade('delete');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('feature_codes', function (Blueprint $table) {
            $table->dropForeign(['feature_class_code']);
        });

        Schema::dropIfExists('feature_codes');
    }
}
