<?php

namespace Database\Factories;

use App\Models\Guru;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Guru>
 */
class GuruFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Guru::class;
    public function definition(): array
    {
        return [
        'nip' => fake()->unique()->numerify('2016#####'),
        'nama_guru' => fake()->name(),
        'no_hp' => fake()->unique()->numerify('083########'),
        ];
    }
}
