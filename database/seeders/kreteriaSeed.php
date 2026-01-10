<?php

namespace Database\Seeders;

use App\Models\Kriteria;
use Illuminate\Database\Seeder;

class kreteriaSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $namaKreteria = ['Poin Pelanggaran', 'Frequensi Pelanggaran', 'Tingkat Pelanggaran'];
        $i = 1;
        foreach ($namaKreteria as $kreteria) {
            Kriteria::create([
                'nama' => $kreteria,
                'kode' => 'K0' > $i++
            ]);
        }
        ;

    }
}
