<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('perizinan', function (Blueprint $table) {
            // $table->id();
            // $table->integer('id_pegawai');
            // $table->foreign('id_pegawai')->references('id_pegawai')->on('users');
            // $table->date('tanggal_awal');
            // $table->date('tanggal_akhir');
            // $table->integer('durasi');
            // $table->string('keterangan');
            $table->id();
            $table->foreignId('user_id');
            $table->date('tanggal_awal');
            $table->date('tanggal_akhir');
            $table->integer('durasi');
            $table->string('keterangan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perizinan');
    }
};
