<?php

namespace Database\Factories;

use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Siswa>
 */
class SiswaFactory extends Factory
{
    protected $model = Siswa::class;

    public function definition(): array
    {
        return [
            'nis' => fake()->unique()->numerify('2025#####'),
            'nama' => fake()->name(),
            'nama_wali' => fake()->name(),
            'no_hp_wali' => fake()->unique()->numerify('08#########'),
            'kelas_id' => Kelas::inRandomOrder()->first()->id ?? 1,
        ];
    }
}
