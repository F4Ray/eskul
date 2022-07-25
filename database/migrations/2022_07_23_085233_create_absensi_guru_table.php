<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbsensiGuruTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('absensi_guru', function (Blueprint $table) {
            $table->id();
            $table->integer('id_guru');
            $table->date('tanggal');
            $table->string('semester');
            $table->string('tahun_ajaran');
            $table->integer('id_keterangan_absensi');
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
        Schema::dropIfExists('absensi_guru');
    }
}