<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePelakuOlahragasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pelaku_olahragas', function (Blueprint $table) {
            $table->id();
            $table->enum('kategori', ['atlit', 'pelatih', 'official', 'koni']);
            $table->string('nama');
            $table->enum('jk', ['L', 'P']);
            $table->string('ttl')->nullable();
            $table->string('nik')->nullable();
            $table->string('no_wa')->nullable();
            $table->string('cabor')->nullable();
            $table->string('kel_cabor')->nullable();
            $table->string('kontingen')->nullable();
            $table->text('alamat')->nullable();
            $table->text('riwayat_kesehatan')->nullable();
            // Khusus KONI
            $table->string('bagian')->nullable();
            $table->string('koni')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pelaku_olahragas');
    }
}
