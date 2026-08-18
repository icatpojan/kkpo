<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataCederaImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_cedera_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('data_cedera_id');
            $table->string('image_path');
            $table->timestamps();

            $table->foreign('data_cedera_id')->references('id')->on('data_cederas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('data_cedera_images');
    }
}
