<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ManajemenTugas>
 */
class ManajemenTugasFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $deskripsi = [
            ['Persuratan', 'menyiapkan surat masuk dan surat keluar di bagian kepaniteraan', 'surat masuk dan surat keluar berhasil dibuat'],
            ['Pengarsipan', 'mengarsipkan surat-surat penting di bagian kearsipan', 'surat-surat penting berhasil diarsipkan'],
            ['Korespondensi', 'menulis surat korespondensi antar lembaga', 'surat korespondensi berhasil dibuat'],
            ['Pelaporan', 'membuat laporan bulanan kegiatan di bagian kepaniteraan', 'laporan bulanan berhasil dibuat'],
            ['Publikasi', 'membuat publikasi kegiatan lembaga', 'publikasi berhasil dibuat'],
            ['Pengajuan', 'mengajukan proposal kegiatan ke bagian keuangan', 'proposal berhasil diajukan'],
            ['Pengawasan', 'melakukan pengawasan keuangan lembaga', 'pengawasan keuangan berhasil dilakukan'],
            ['Pengawasan', 'melakukan pengawasan kinerja pegawai', 'pengawasan kinerja pegawai berhasil dilakukan'],
            ['Pengawasan', 'melakukan pengawasan kualitas pelayanan', 'pengawasan kualitas pelayanan berhasil dilakukan'],
            ['Pengawasan', 'melakukan pengawasan keamanan dan keselamatan lembaga', 'pengawasan keamanan dan keselamatan lembaga berhasil dilakukan'],
        ];
        return [
            'nama_tugas' => $this->faker->randomElement($deskripsi[0]),
            'karyawan_id' => \App\Models\Karyawan::all()->random()->id,
            'deskripsi' => $this->faker->randomElement($deskripsi[1]),
            'tanggal_mulai' => Carbon::now()->subDays(rand(1, 7))->format('Y-m-d'),
            'status_tugas_id' => $this->faker->numberBetween(1, 3),
            'tanggal_selesai' => function (array $attributes) {
                return $attributes['status_tugas_id'] != 3 ? Carbon::now()->subDays(rand(1, 7))->format('Y-m-d') : null;
            },
            'file' => 'test.pdf',
            'karyawan_id' => \App\Models\Karyawan::all()->random()->id,
            'capaian' => $this->faker->randomElement($deskripsi[2]),
            'created_at' => function (array $attributes) {
                return $attributes['tanggal_mulai'];
            },
            'updated_at' => function (array $attributes) {
                return $attributes['tanggal_mulai'];
            },
        ];
    }
}
