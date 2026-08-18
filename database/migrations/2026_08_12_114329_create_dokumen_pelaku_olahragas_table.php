<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDokumenPelakuOlahragasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dokumen_pelaku_olahragas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pelaku_olahraga_id');
            $table->string('file_path');
            $table->string('nama_file')->nullable();
            $table->timestamps();

            $table->foreign('pelaku_olahraga_id')->references('id')->on('pelaku_olahragas')->onDelete('cascade');
        });

        // Migrate existing documents from pelaku_olahragas to the new table
        $pelakus = \DB::table('pelaku_olahragas')->whereNotNull('dokumen')->get();
        foreach ($pelakus as $pelaku) {
            if (!empty($pelaku->dokumen)) {
                \DB::table('dokumen_pelaku_olahragas')->insert([
                    'pelaku_olahraga_id' => $pelaku->id,
                    'file_path' => $pelaku->dokumen,
                    'nama_file' => 'Dokumen Lama',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dokumen_pelaku_olahragas');
    }
}
