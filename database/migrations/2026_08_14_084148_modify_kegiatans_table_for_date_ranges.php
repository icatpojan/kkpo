<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyKegiatansTableForDateRanges extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kegiatans', function (Blueprint $table) {
            $table->date('tanggal_mulai')->nullable()->after('nama_kegiatan');
            $table->date('tanggal_selesai')->nullable()->after('tanggal_mulai');
            $table->dropColumn(['tanggal', 'alamat', 'link_google_map']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kegiatans', function (Blueprint $table) {
            $table->date('tanggal')->nullable()->after('nama_kegiatan');
            $table->dropColumn(['tanggal_mulai', 'tanggal_selesai']);
            $table->text('alamat')->nullable();
            $table->string('link_google_map')->nullable();
        });
    }
}
