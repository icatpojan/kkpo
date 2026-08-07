<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKkpoSebantensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kkpo_sebantens', function (Blueprint $table) {
            $table->id();
            $table->string('wadah');
            $table->string('npp')->nullable();
            $table->text('alamat_kantor')->nullable();
            $table->string('no_tlp')->nullable();
            $table->string('nama_personil')->nullable();
            $table->string('email')->nullable();
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
        Schema::dropIfExists('kkpo_sebantens');
    }
}
