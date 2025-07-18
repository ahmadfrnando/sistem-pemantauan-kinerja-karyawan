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
        Schema::create('status_tugas', function (Blueprint $table) {
            $table->id();
            $table->string('status');
            $table->timestamps();
        });

        DB::table('status_tugas')->insert([
            ['id' => 1, 'status' => 'Belum Dikerjakan'],
            ['id' => 2, 'status' => 'Sedang Dikerjakan'],
            ['id' => 3 ,'status' => 'Selesai'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('status_tugas');
    }
};
