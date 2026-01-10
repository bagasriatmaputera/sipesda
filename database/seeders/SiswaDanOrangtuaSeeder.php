<?php

namespace Database\Seeders;

use App\Models\OrangTua;
use App\Models\Siswa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SiswaDanOrangtuaSeeder extends Seeder
{
    public function run(): void
    {
        // Membuat 90 siswa, masing-masing otomatis dibuatkan 1 orang tua
        Siswa::factory()
            ->count(90)
            ->create();
    }
}
