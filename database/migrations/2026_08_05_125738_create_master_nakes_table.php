<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterNakesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_nakes', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('spesialisasi');
            $table->string('no_str')->nullable();
            $table->string('instansi')->nullable();
            $table->string('no_wa')->nullable();
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
        Schema::dropIfExists('master_nakes');
    }
}
