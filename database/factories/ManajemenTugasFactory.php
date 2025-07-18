<?php

namespace Database\Factories;

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
        return [
            'nama_tugas' => $this->faker->jobTitle(),
            'karyawan_id' => \App\Models\Karyawan::factory()->create()->id,
            'status_tugas_id' => $this->faker->randomElement([1, 2, 3]),
        ];
    }
}
