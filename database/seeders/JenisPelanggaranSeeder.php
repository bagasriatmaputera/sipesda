<?php

namespace Database\Seeders;

use App\Models\JenisPelanggaran;
use Illuminate\Database\Seeder;

class JenisPelanggaranSeeder extends Seeder
{
    public function run()
    {
        $data = [
            // PELANGGARAN RINGAN
            ['nama_pelanggaran' => 'Tidak memakai seragam lengkap', 'kategori' => 'ringan', 'poin' => 2],
            ['nama_pelanggaran' => 'Tidak memakai perlengkapan upacara seperti Peci, Rompi, dan ikat pinggang', 'kategori' => 'ringan', 'poin' => 2],
            ['nama_pelanggaran' => 'Siswi memakai perhiasan berlebihan', 'kategori' => 'ringan', 'poin' => 2],
            ['nama_pelanggaran' => 'Terlambat lebih dari 10 menit dari jam 06.30 wib', 'kategori' => 'ringan', 'poin' => 2],
            ['nama_pelanggaran' => 'Absen tanpa keterangan 3 kali berturut-turut', 'kategori' => 'ringan', 'poin' => 3],
            ['nama_pelanggaran' => 'Berambut gondrong, atau dicukur tidak rapi (putra)', 'kategori' => 'ringan', 'poin' => 3],
            ['nama_pelanggaran' => 'Berkuku panjang, tidak memakai sepatu berwarna, tidak memakai ciput', 'kategori' => 'ringan', 'poin' => 3],
            ['nama_pelanggaran' => 'Membuang sampah di sembarang tempat', 'kategori' => 'ringan', 'poin' => 3],
            ['nama_pelanggaran' => 'Mengecat (mewarnai) rambut/kuku/badan', 'kategori' => 'ringan', 'poin' => 3],
            ['nama_pelanggaran' => 'Mengenakan gelang, kalung (putra)', 'kategori' => 'ringan', 'poin' => 5],
            ['nama_pelanggaran' => 'Mengotori, mencorat-coret benda, dan merusak milik madrasah', 'kategori' => 'ringan', 'poin' => 5],

            // PELANGGARAN SEDANG
            ['nama_pelanggaran' => 'Mencemarkan nama baik sekolah', 'kategori' => 'sedang', 'poin' => 10],
            ['nama_pelanggaran' => 'Tidak mengikuti upacara bendera tanpa keterangan', 'kategori' => 'sedang', 'poin' => 10],
            ['nama_pelanggaran' => 'Tidak mengikuti pelajaran tanpa izin', 'kategori' => 'sedang', 'poin' => 10],
            ['nama_pelanggaran' => 'Menggambar di anggota tubuh', 'kategori' => 'sedang', 'poin' => 10],
            ['nama_pelanggaran' => 'Menjadi provokator ribut di kelas/ perkelahian', 'kategori' => 'sedang', 'poin' => 10],
            ['nama_pelanggaran' => 'Bermain kartu di lingkungan madrasah', 'kategori' => 'sedang', 'poin' => 10],
            ['nama_pelanggaran' => 'Bermain bola di dalam kelas', 'kategori' => 'sedang', 'poin' => 10],
            ['nama_pelanggaran' => 'Meninggalkan jam pelajaran tanpa izin guru/ piket/ BK', 'kategori' => 'sedang', 'poin' => 10],
            ['nama_pelanggaran' => 'Bolos saat Kegiatan Belajar Mengajar (KBM)', 'kategori' => 'sedang', 'poin' => 15],
            ['nama_pelanggaran' => 'Memalsukan tanda tangan', 'kategori' => 'sedang', 'poin' => 15],
            ['nama_pelanggaran' => 'Melakukan pemalakan dan / pengancaman', 'kategori' => 'sedang', 'poin' => 15],
            ['nama_pelanggaran' => 'Membuat keterangan palsu', 'kategori' => 'sedang', 'poin' => 15],
            ['nama_pelanggaran' => 'Membawa sepeda motor di dalam lingkungan Madrasah', 'kategori' => 'sedang', 'poin' => 15],
            ['nama_pelanggaran' => 'Terlibat Masalah Rokok di dalam lingkungan madrasah', 'kategori' => 'sedang', 'poin' => 15],
            ['nama_pelanggaran' => 'Siswa bertindik/memakai anting', 'kategori' => 'sedang', 'poin' => 15],
            ['nama_pelanggaran' => 'Membawa barang elektronik (HP, Laptop, dll) tanpa izin', 'kategori' => 'sedang', 'poin' => 15],
            ['nama_pelanggaran' => 'Merusak/ mengambil/ menghilangkan barang milik orang lain', 'kategori' => 'sedang', 'poin' => 15],

            // PELANGGARAN BERAT
            ['nama_pelanggaran' => 'Terlibat Pornografi (baik upload dan unduh)', 'kategori' => 'berat', 'poin' => 75],
            ['nama_pelanggaran' => 'Membawa senjata tajam dan atau senjata api tanpa izin', 'kategori' => 'berat', 'poin' => 80],
            ['nama_pelanggaran' => 'Berjudi dalam bentuk apapun dilingkungan Madrasah', 'kategori' => 'berat', 'poin' => 80],
            ['nama_pelanggaran' => 'Terlibat perbuatan Asusila', 'kategori' => 'berat', 'poin' => 80],
            ['nama_pelanggaran' => 'Terlibat perkelahian antar pelajar di luar madrasah', 'kategori' => 'berat', 'poin' => 85],
            ['nama_pelanggaran' => 'Melukai dengan senjata tajam atau senjata api', 'kategori' => 'berat', 'poin' => 90],
            ['nama_pelanggaran' => 'Terlibat masalah narkoba dan atau miras', 'kategori' => 'berat', 'poin' => 95],
            ['nama_pelanggaran' => 'Memakai tato Permanen', 'kategori' => 'berat', 'poin' => 95],
            ['nama_pelanggaran' => 'Hamil di luar nikah', 'kategori' => 'berat', 'poin' => 100],
            ['nama_pelanggaran' => 'Terlibat tindak pidana', 'kategori' => 'berat', 'poin' => 100],
        ];

        foreach ($data as $item) {
            JenisPelanggaran::create($item);
        }
    }
}
