<?php

namespace Database\Seeders;

use App\Models\OrangTua;
use App\Models\Siswa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SiswaDanOrangtuaSeeder extends Seeder
{
    public function run(): void
    {
        $dataSiswa = [
            ['nama' => 'Arya Anugrah Nur\'rais', 'nama_wali' => 'Leny Novita', 'no_hp_wali' => '089676100778'],
            ['nama' => 'Fathan Albie Anwar', 'nama_wali' => 'Lisnawati Dewi', 'no_hp_wali' => '082299836533'],
            ['nama' => 'Restu Sujana', 'nama_wali' => 'Nurjanah', 'no_hp_wali' => '6285210209002'],
            ['nama' => 'Haafizhah Irfiansyah', 'nama_wali' => 'Lianah', 'no_hp_wali' => '628384058316'],
            ['nama' => 'Ayman Rafa Arizki', 'nama_wali' => 'Esti Nurjanah', 'no_hp_wali' => '628999972249'],
            ['nama' => 'Arya Aditya Heryanto', 'nama_wali' => 'Waryuni', 'no_hp_wali' => '0895604496119'],
            ['nama' => 'Tsabita Maila Rabbani', 'nama_wali' => 'Rina Hartatik', 'no_hp_wali' => '6283806424378'],
            ['nama' => 'Wasilatuzahra', 'nama_wali' => 'Dastim', 'no_hp_wali' => '6285810094600'],
            ['nama' => 'Alanna Syahquitta Faust', 'nama_wali' => 'Istiqomah', 'no_hp_wali' => '6281317491330'],
            ['nama' => 'Vania Aurellia', 'nama_wali' => 'Dewi Ariyati', 'no_hp_wali' => '628568622156'],
            ['nama' => 'Aqilla Shafa Avizenna', 'nama_wali' => 'Nursari', 'no_hp_wali' => '6285213546886'],
            ['nama' => 'Alrazi Rabbani Akbar', 'nama_wali' => 'Selviah', 'no_hp_wali' => '628213548295'],
            ['nama' => 'Kaban Maula Utbah', 'nama_wali' => 'Aminah', 'no_hp_wali' => '6289505806106'],
            ['nama' => 'Nazriel Raffa Syah', 'nama_wali' => 'Ervika Suci', 'no_hp_wali' => '6282340563129'],
            ['nama' => 'Rangga Sidiq Nur Rochman', 'nama_wali' => 'Sri Lestari', 'no_hp_wali' => '6281905213312'],
            ['nama' => 'Nayla Anindya Zhafirah', 'nama_wali' => 'Dwi Septianingsih', 'no_hp_wali' => '6285782249688'],
            ['nama' => 'Dafa Nur Khaliq', 'nama_wali' => 'Nadia Kurniati', 'no_hp_wali' => '081381901683'],
            ['nama' => 'Faidatul Hasanah', 'nama_wali' => 'Sunariyah', 'no_hp_wali' => '6282113673728'],
            ['nama' => 'Muhammad Alfan', 'nama_wali' => 'Muisah', 'no_hp_wali' => '6285811077818'],
            ['nama' => 'Erlang Syauqi Hadi', 'nama_wali' => 'Qolbinnisa', 'no_hp_wali' => '081285015776'],
            ['nama' => 'Fika Aqilah Kirani', 'nama_wali' => 'Petriani', 'no_hp_wali' => '087889914730'],
        ];

        // Format awal NIS (misal: 24250001 untuk tahun ajaran ini)
        $startNis = 24250001; 

        foreach ($dataSiswa as $index => $siswa) {
            DB::table('siswa')->insert([
                'nis'         => $startNis + $index,
                'nama'        => $siswa['nama'],
                'nama_wali'   => $siswa['nama_wali'],
                'photo'       => 'default.jpg',
                'no_hp_wali'  => $siswa['no_hp_wali'],
                'kelas_id'    => 1,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }
    }
}
