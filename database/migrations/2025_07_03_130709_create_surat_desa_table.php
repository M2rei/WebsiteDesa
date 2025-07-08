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
            $table->unsignedBigInteger('desa_id');
            $table->string('dokumen');
            $table->enum('status', ['diproses', 'selesai'])->default('diproses');
            $table->timestamps();

            $table->foreign('desa_id')->references('id')->on('desa')->onDelete('cascade');
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
