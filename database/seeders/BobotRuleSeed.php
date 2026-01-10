<?php

namespace Database\Seeders;

use App\Models\BobotRules;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BobotRuleSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bobotPerTahap = [
            1 => [0.2, 0.3, 0.5], // Peringatan Lisan
            2 => [0.3, 0.4, 0.3], // SP 1
            3 => [0.4, 0.4, 0.2], // SP 2
            4 => [0.5, 0.2, 0.3], // Skorsing
            5 => [0.5, 0.2, 0.3], // Dikeluarkan
        ];

        foreach ($bobotPerTahap as $tahapId => $bobotArray) {
            foreach ($bobotArray as $kriteriaIndex => $bobot) {
                BobotRules::create([
                    'tahap_id' => $tahapId,
                    'kriteria_id' => $kriteriaIndex + 1,
                    'bobot' => $bobot
                ]);
            }
        }
    }
}
