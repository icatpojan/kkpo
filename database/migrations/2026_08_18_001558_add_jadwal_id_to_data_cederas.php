<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddJadwalIdToDataCederas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('data_cederas', function (Blueprint $table) {
            $table->unsignedBigInteger('jadwal_pertandingan_id')->nullable()->after('nakes_jaga_id');
            $table->foreign('jadwal_pertandingan_id')->references('id')->on('jadwal_pertandingans')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('data_cederas', function (Blueprint $table) {
            $table->dropForeign(['jadwal_pertandingan_id']);
            $table->dropColumn('jadwal_pertandingan_id');
        });
    }
}
