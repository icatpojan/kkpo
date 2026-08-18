<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDokumenToPelakuOlahragasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pelaku_olahragas', function (Blueprint $table) {
            $table->string('dokumen')->nullable()->after('koni');
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
            $table->dropColumn('dokumen');
        });
    }
}
