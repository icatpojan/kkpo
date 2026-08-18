<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToNakesJagasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nakes_jagas', function (Blueprint $table) {
            $table->date('tanggal')->nullable();
            $table->string('cabor')->nullable();
            $table->string('venue')->nullable();
            $table->integer('jumlah_cedera')->nullable()->default(0);
            $table->string('instansi')->nullable();
            $table->string('lini1')->nullable();
            $table->string('lini2')->nullable();
            $table->string('lini3')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nakes_jagas', function (Blueprint $table) {
            $table->dropColumn([
                'tanggal', 'cabor', 'venue', 'jumlah_cedera',
                'instansi', 'lini1', 'lini2', 'lini3'
            ]);
        });
    }
}
