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
        Schema::create('surat_desa', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_surat');
            $table->string('nama');
            $table->string('nik');
            $table->string('tempat_tgl_lahir');
            $table->string('jenis_kelamin');
            $table->string('agama');
            $table->string('pekerjaan');
            $table->string('no_telepon');
            $table->string('alamat');
            $table->string('catatan_pemohon')->nullable();
            $table->enum('status', ['diproses', 'selesai'])->default('diproses');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_desa');
    }
};
