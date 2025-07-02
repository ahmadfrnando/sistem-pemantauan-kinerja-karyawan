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
        Schema::table('kinerja', function (Blueprint $table) {
            $table->integer('status_kehadiran_id')->default(1);
            $table->dropColumn('persentase_kehadiran');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kinerja', function (Blueprint $table) {
            $table->dropColumn('status_kehadiran_id');
            $table->float('persentase_kehadiran');
        });
    }
};
