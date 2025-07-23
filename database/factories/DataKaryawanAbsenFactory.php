<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DataKaryawanAbsen>
 */
class DataKaryawanAbsenFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'karyawan_id' => \App\Models\Karyawan::all()->random()->id,
            'tanggal' => Carbon::now()->subDays(rand(1, 7))->format('Y-m-d'),
            'jenis_absen' => 'masuk',
            'jam_absen' => '08:00:00',
            'status' => 'hadir',
            'bukti_absen' => 'test.jpg',
            'created_at' => function (array $attributes) {
                return Carbon::now()->subDays(rand(1, 7))->format('Y-m-d H:i:s');
            },
            'updated_at' => function (array $attributes) {
                return Carbon::now()->subDays(rand(1, 7))->format('Y-m-d H:i:s');
            },
        ];
    }
}
