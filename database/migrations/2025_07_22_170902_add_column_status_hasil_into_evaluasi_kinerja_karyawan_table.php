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
        Schema::table('evaluasi_kinerja_karyawan', function (Blueprint $table) {
            $table->enum('status_hasil', ['sangat baik', 'baik', 'cukup', 'kurang'])->default('sangat baik')->after('total_skor');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('evaluasi_kinerja_karyawan', function (Blueprint $table) {
            $table->dropColumn('status_hasil');
        });
    }
};
