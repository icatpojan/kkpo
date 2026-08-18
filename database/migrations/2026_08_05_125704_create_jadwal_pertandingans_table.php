<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJadwalPertandingansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jadwal_pertandingans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kegiatan_id')->nullable();
            $table->string('jenis_cabor');
            $table->string('kel_cabor')->nullable();
            $table->string('venue');
            $table->integer('jumlah_lapangan')->nullable();
            $table->date('tanggal');
            $table->string('waktu');
            $table->timestamps();

            $table->foreign('kegiatan_id')->references('id')->on('kegiatans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jadwal_pertandingans');
    }
}
