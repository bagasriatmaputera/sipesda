<?php

namespace Database\Seeders;

use App\Models\Tahap;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class tahapSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $desTahap = [
            'Peringatan Lisan dan istigfar',
            'Panggilan Orang Tua / Wali Murid & SP 1',
            'Panggilan Orang Tua / Wali Murid & SP 2',
            'Dikembalikan kepada orang tua dalam jangka waktu tertentu (skorsing) 7 hari / 1 minggu.',
            'Dikembalikan kepada orang tua selamanya',
        ];

        $i = 1;
        $o= 1;

        foreach ($desTahap as $tahap) {
            Tahap::create(([
                'nama' => 'Tahap ' . $i++,
                'kode' => 'T0' . $o++,
                'deskripsi' => $tahap
            ]));
        };
    }
}
