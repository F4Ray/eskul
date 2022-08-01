<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbsensiSiswaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('absensi_siswa', function (Blueprint $table) {
            $table->id();
            $table->integer('id_siswa');
            $table->integer('id_guru');
            $table->integer('id_jadwal');
            $table->date('tanggal');
            $table->string('tahun_ajaran');
            $table->integer('id_keterangan_absensi')->nullable();
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
        Schema::dropIfExists('absensi_siswa');
    }
}
