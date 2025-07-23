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
        Schema::dropIfExists('data_karyawan_absen');

        Schema::create('data_karyawan_absen', function (Blueprint $table) {
            $table->id();
            $table->integer('karyawan_id');
            $table->date('tanggal');
            $table->time('jam_absen');
            $table->enum('jenis_absen', ['masuk', 'pulang'])->default('masuk');
            $table->enum('status', ['hadir', 'absen'])->default('hadir');
            $table->text('bukti_absen')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_karyawan_absen');
    }
};
