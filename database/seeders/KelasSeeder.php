<?php

namespace Database\Seeders;

use App\Models\Kelas;
use Illuminate\Database\Seeder;

class KelasSeeder extends Seeder
{
    public function run()
    {
        $kelas = [
            'VII.A',
            'VII.B',
            'VII.C',
            'VII.D',
            'VIII.A',
            'VIII.B',
            'VIII.C',
            'VIII.D',
            'IX.A',
            'IX.B',
            'IX.C',
            'IX.D',
        ];

        foreach ($kelas as $kodeKelas) {
            $kode = Kelas::firstOrCreate(['nama_kelas' => $kodeKelas]);
        }
    }
}
