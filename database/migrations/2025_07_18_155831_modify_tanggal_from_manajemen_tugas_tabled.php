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
        Schema::table('manajemen_tugas', function (Blueprint $table) {
            $table->date('tanggal_mulai')->nullable()->change();
            $table->date('tanggal_selesai')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('manajemen_tugas', function (Blueprint $table) {
            $table->datetime('tanggal_mulai')->nullable()->change();
            $table->datetime('tanggal_selesai')->nullable()->change();
        });
    }
};
