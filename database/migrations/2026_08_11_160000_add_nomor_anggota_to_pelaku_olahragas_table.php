<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNomorAnggotaToPelakuOlahragasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pelaku_olahragas', function (Blueprint $table) {
            $table->string('nomor_anggota')->nullable()->after('id')->unique();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pelaku_olahragas', function (Blueprint $table) {
            $table->dropColumn('nomor_anggota');
        });
    }
}
