<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHasilPertandingansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hasil_pertandingans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kegiatan_id');
            $table->string('cabor');
            
            // Medali Emas
            $table->unsignedBigInteger('emas_pelaku_id')->nullable();
            $table->string('emas_kontingen')->nullable();
            
            // Medali Perak
            $table->unsignedBigInteger('perak_pelaku_id')->nullable();
            $table->string('perak_kontingen')->nullable();
            
            // Medali Perunggu
            $table->unsignedBigInteger('perunggu_pelaku_id')->nullable();
            $table->string('perunggu_kontingen')->nullable();
            
            $table->timestamps();

            $table->foreign('kegiatan_id')->references('id')->on('kegiatans')->onDelete('cascade');
            $table->foreign('emas_pelaku_id')->references('id')->on('pelaku_olahragas')->onDelete('set null');
            $table->foreign('perak_pelaku_id')->references('id')->on('pelaku_olahragas')->onDelete('set null');
            $table->foreign('perunggu_pelaku_id')->references('id')->on('pelaku_olahragas')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hasil_pertandingans');
    }
}
