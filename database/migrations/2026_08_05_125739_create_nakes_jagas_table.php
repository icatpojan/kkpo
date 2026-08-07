<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNakesJagasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nakes_jagas', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('cabor');
            $table->string('venue');
            $table->foreignId('nakes_id')->constrained('master_nakes')->onDelete('cascade');
            $table->text('personil')->nullable();
            $table->integer('jumlah_cedera')->default(0);
            $table->text('keterangan')->nullable();
            $table->string('upload_absen')->nullable();
            $table->string('upload_foto')->nullable();
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
        Schema::dropIfExists('nakes_jagas');
    }
}
