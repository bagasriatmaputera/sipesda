<?php

namespace Database\Seeders;

use App\Models\JenisPelanggaran;
use App\Models\TingkatPelanggaran;
use Illuminate\Database\Seeder;

class JenisPelanggaranSeeder extends Seeder
{
    public function run()
    {
        $tingkatPelanggaran = ['rendah','sedang','berat'];
        $i = 1;

        foreach ($tingkatPelanggaran as $q) {
            TingkatPelanggaran::create([
                'tingkat' => $q,
                'nilai' => $i++
            ]);
        }

        $data = [
            // PELANGGARAN RINGAN
            ['nama_pelanggaran' => 'Tidak memakai seragam lengkap', 'tingkat_pelanggaran_id' => 1, 'poin' => 2],
            ['nama_pelanggaran' => 'Tidak memakai perlengkapan upacara seperti Peci, Rompi, dan ikat pinggang', 'tingkat_pelanggaran_id' => 1, 'poin' => 2],
            ['nama_pelanggaran' => 'Siswi memakai perhiasan berlebihan', 'tingkat_pelanggaran_id' => 1, 'poin' => 2],
            ['nama_pelanggaran' => 'Terlambat lebih dari 10 menit dari jam 06.30 wib', 'tingkat_pelanggaran_id' => 1, 'poin' => 2],
            ['nama_pelanggaran' => 'Absen tanpa keterangan 3 kali berturut-turut', 'tingkat_pelanggaran_id' => 1, 'poin' => 3],
            ['nama_pelanggaran' => 'Berambut gondrong, atau dicukur tidak rapi (putra)', 'tingkat_pelanggaran_id' => 1, 'poin' => 3],
            ['nama_pelanggaran' => 'Berkuku panjang, tidak memakai sepatu berwarna, tidak memakai ciput', 'tingkat_pelanggaran_id' => 1, 'poin' => 3],
            ['nama_pelanggaran' => 'Membuang sampah di sembarang tempat', 'tingkat_pelanggaran_id' => 1, 'poin' => 3],
            ['nama_pelanggaran' => 'Mengecat (mewarnai) rambut/kuku/badan', 'tingkat_pelanggaran_id' => 1, 'poin' => 3],
            ['nama_pelanggaran' => 'Mengenakan gelang, kalung (putra)', 'tingkat_pelanggaran_id' => 1, 'poin' => 5],
            ['nama_pelanggaran' => 'Mengotori, mencorat-coret benda, dan merusak milik madrasah', 'tingkat_pelanggaran_id' => 1, 'poin' => 5],

            // PELANGGARAN SEDANG
            ['nama_pelanggaran' => 'Mencemarkan nama baik sekolah', 'tingkat_pelanggaran_id' => 2, 'poin' => 10],
            ['nama_pelanggaran' => 'Tidak mengikuti upacara bendera tanpa keterangan', 'tingkat_pelanggaran_id' => 2, 'poin' => 10],
            ['nama_pelanggaran' => 'Tidak mengikuti pelajaran tanpa izin', 'tingkat_pelanggaran_id' => 2, 'poin' => 10],
            ['nama_pelanggaran' => 'Menggambar di anggota tubuh', 'tingkat_pelanggaran_id' => 2, 'poin' => 10],
            ['nama_pelanggaran' => 'Menjadi provokator ribut di kelas/ perkelahian', 'tingkat_pelanggaran_id' => 2, 'poin' => 10],
            ['nama_pelanggaran' => 'Bermain kartu di lingkungan madrasah', 'tingkat_pelanggaran_id' => 2, 'poin' => 10],
            ['nama_pelanggaran' => 'Bermain bola di dalam kelas', 'tingkat_pelanggaran_id' => 2, 'poin' => 10],
            ['nama_pelanggaran' => 'Meninggalkan jam pelajaran tanpa izin guru/ piket/ BK', 'tingkat_pelanggaran_id' => 2, 'poin' => 10],
            ['nama_pelanggaran' => 'Bolos saat Kegiatan Belajar Mengajar (KBM)', 'tingkat_pelanggaran_id' => 2, 'poin' => 15],
            ['nama_pelanggaran' => 'Memalsukan tanda tangan', 'tingkat_pelanggaran_id' => 2, 'poin' => 15],
            ['nama_pelanggaran' => 'Melakukan pemalakan dan / pengancaman', 'tingkat_pelanggaran_id' => 2, 'poin' => 15],
            ['nama_pelanggaran' => 'Membuat keterangan palsu', 'tingkat_pelanggaran_id' => 2, 'poin' => 15],
            ['nama_pelanggaran' => 'Membawa sepeda motor di dalam lingkungan Madrasah', 'tingkat_pelanggaran_id' => 2, 'poin' => 15],
            ['nama_pelanggaran' => 'Terlibat Masalah Rokok di dalam lingkungan madrasah', 'tingkat_pelanggaran_id' => 2, 'poin' => 15],
            ['nama_pelanggaran' => 'Siswa bertindik/memakai anting', 'tingkat_pelanggaran_id' => 2, 'poin' => 15],
            ['nama_pelanggaran' => 'Membawa barang elektronik (HP, Laptop, dll) tanpa izin', 'tingkat_pelanggaran_id' => 2, 'poin' => 15],
            ['nama_pelanggaran' => 'Merusak/ mengambil/ menghilangkan barang milik orang lain', 'tingkat_pelanggaran_id' => 2, 'poin' => 15],

            // PELANGGARAN BERAT
            ['nama_pelanggaran' => 'Terlibat Pornografi (baik upload dan unduh)', 'tingkat_pelanggaran_id' => 3, 'poin' => 75],
            ['nama_pelanggaran' => 'Membawa senjata tajam dan atau senjata api tanpa izin', 'tingkat_pelanggaran_id' => 3, 'poin' => 80],
            ['nama_pelanggaran' => 'Berjudi dalam bentuk apapun dilingkungan Madrasah', 'tingkat_pelanggaran_id' => 3, 'poin' => 80],
            ['nama_pelanggaran' => 'Terlibat perbuatan Asusila', 'tingkat_pelanggaran_id' => 3, 'poin' => 80],
            ['nama_pelanggaran' => 'Terlibat perkelahian antar pelajar di luar madrasah', 'tingkat_pelanggaran_id' => 3, 'poin' => 85],
            ['nama_pelanggaran' => 'Melukai dengan senjata tajam atau senjata api', 'tingkat_pelanggaran_id' => 3, 'poin' => 90],
            ['nama_pelanggaran' => 'Terlibat masalah narkoba dan atau miras', 'tingkat_pelanggaran_id' => 3, 'poin' => 95],
            ['nama_pelanggaran' => 'Memakai tato Permanen', 'tingkat_pelanggaran_id' => 3, 'poin' => 95],
            ['nama_pelanggaran' => 'Hamil di luar nikah', 'tingkat_pelanggaran_id' => 3, 'poin' => 100],
            ['nama_pelanggaran' => 'Terlibat tindak pidana', 'tingkat_pelanggaran_id' => 3, 'poin' => 100],
        ];

        foreach ($data as $item) {
            JenisPelanggaran::create($item);
        }
    }
}
