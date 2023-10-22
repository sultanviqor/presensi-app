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
        Schema::create('users', function (Blueprint $table) {
            //     $table->integer('id_pegawai')->primary();
            //     $table->string('nip')->unique();
            //     $table->string('nama');
            //     $table->string('golongan');
            //     $table->string('password');
            //     $table->string('jabatan');
            //     $table->string('foto');
            //     $table->timestamps();
            $table->id();
            $table->integer('nip')->unique();
            $table->string('nama');
            $table->string('jabatan');
            $table->string('golongan');
            $table->string('foto');
            $table->string('password');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
