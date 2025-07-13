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
        Schema::create('ternak_peternak', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peternak_id')->constrained()->onDelete('cascade');
            $table->foreignId('ternak_id')->constrained()->onDelete('cascade');
            $table->enum('jenis_kelamin', ['Jantan', 'Betina']);
            $table->integer('jumlah');
            $table->string('jenis_pakan')->nullable();
            $table->string('penyakit')->nullable();
            $table->string('sistem_pemeliharaan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ternak_peternak');
    }
};
