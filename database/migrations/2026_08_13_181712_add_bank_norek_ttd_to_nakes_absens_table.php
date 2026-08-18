<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBankNorekTtdToNakesAbsensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nakes_absens', function (Blueprint $table) {
            $table->string('bank')->nullable()->after('keterangan');
            $table->string('norek')->nullable()->after('bank');
            $table->text('tanda_tangan')->nullable()->after('foto');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nakes_absens', function (Blueprint $table) {
            $table->dropColumn(['bank', 'norek', 'tanda_tangan']);
        });
    }
}
