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
        Schema::create('laporan_kinerja', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kinerja_id');
            $table->unsignedBigInteger('atasan_id');
            $table->string('nama_laporan');
            $table->text('laporan');
            $table->string('laporan_file');
            $table->date('tanggal_laporan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_kinerja');
    }
};
