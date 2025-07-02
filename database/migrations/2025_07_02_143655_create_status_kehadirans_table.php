<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('status_kehadiran', function (Blueprint $table) {
            $table->id();
            $table->string('status');
            $table->timestamps();
        });

        DB::table('status_kehadiran')->insert([
            ['id' => 1, 'status' => 'Hadir'],
            ['id' => 2, 'status' => 'Izin'],
            ['id' => 3, 'status' => 'Sakit'],
            ['id' => 4, 'status' => 'Cuti'],
            ['id' => 5, 'status' => 'Tidak Hadir'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('status_kehadiran');
    }
};
