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
        Schema::create('absen', function (Blueprint $table) {
            //     $table->id();
            //     $table->integer('id');
            //     $table->foreign('id')->references('id')->on('users');
            //     $table->date('tanggal');
            //     $table->time('jam_masuk')->nullable();
            //     $table->time('jam_pulang')->nullable();
            //     $table->integer('jam_kerja')->nullable();
            //     $table->string('jenis_absen');
            //     $table->string('lokasi')->nullable();
            $table->id();
            $table->foreignId('user_id');
            $table->date('tanggal');
            $table->time('jam_masuk')->nullable();
            $table->time('jam_pulang')->nullable();
            $table->integer('jam_kerja')->nullable();
            $table->enum('jenis_absen', ['Masuk', 'Tidak Masuk', 'Izin']);
            $table->string('lokasi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absen');
    }
};
