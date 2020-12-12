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
            $table->id();
            $table->string('code')->unique();
            $table->string('short_description')->nullable();
            $table->text('full_description')->nullable();
            $table->unsignedBigInteger('feature_class_id');
            $table->timestamps();
        });

        Schema::table('feature_codes', function (Blueprint $table) {
            $table->foreign('feature_class_id')->references('id')->on('feature_classes')->onCascade('delete');
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
            $table->dropForeign(['feature_class_id']);
        });

        Schema::dropIfExists('feature_codes');
    }
}
