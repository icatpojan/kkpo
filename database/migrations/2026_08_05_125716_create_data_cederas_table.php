<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataCederasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_cederas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pelaku_olahraga_id');
            $table->dateTime('waktu_kejadian')->nullable();
            $table->string('event')->nullable();
            $table->string('venue')->nullable();
            $table->string('bagian_cedera')->nullable();
            $table->text('kronologis')->nullable();
            $table->text('penanganan')->nullable();
            $table->string('status')->default('cedera'); // cedera, rujuk, sembuh
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('pelaku_olahraga_id')->references('id')->on('pelaku_olahragas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('data_cederas');
    }
}
