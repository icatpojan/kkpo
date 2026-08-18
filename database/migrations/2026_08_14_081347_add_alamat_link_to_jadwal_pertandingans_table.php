<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAlamatLinkToJadwalPertandingansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jadwal_pertandingans', function (Blueprint $table) {
            $table->string('alamat')->nullable()->after('venue');
            $table->text('link_google_map')->nullable()->after('alamat');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jadwal_pertandingans', function (Blueprint $table) {
            $table->dropColumn(['alamat', 'link_google_map']);
        });
    }
}
