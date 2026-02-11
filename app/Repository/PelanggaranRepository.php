<?php

namespace App\Repository;

use App\Models\Pelanggaran;

class PelanggaranRepository
{
    public function getAll(string $keyword)
    {
        if ($keyword) {
            return Pelanggaran::with([
                'siswa:id,nama,kelas_id,nis',
                'guru:id,nama_guru',
                'siswa.kelas:id,nama_kelas',
                'jenisPelanggaran:id,nama_pelanggaran,tingkat_pelanggaran_id,poin'
            ])->whereHas('siswa', function ($q) use ($keyword) {
                $q->where('nama', 'LIKE', '%' . $keyword . '%');
                $q->orWhere('nis', 'LIKE', '%' . $keyword . '%');
            })->latest()->get();
        }

        return Pelanggaran::with(['siswa', 'guru', 'jenisPelanggaran'])
            ->latest()
            ->paginate(50);
    }

    public function getById(int $id)
    {
        return Pelanggaran::with([
            'siswa:id,nama,kelas_id',
            'guru:id,nama_guru',
            'siswa.kelas:id,nama_kelas',
            'jenisPelanggaran:id,nama_pelanggaran,tingkat_pelanggaran_id,poin'
        ])
            ->findOrFail($id);
    }

    public function getBySiswaId(int $siswaId)
    {
        return Pelanggaran::where('siswa_id', $siswaId)
            ->latest()
            ->get();
    }

    public function create(array $data)
    {
        return Pelanggaran::create($data);
    }

    public function update(int $id, array $data)
    {
        $pelanggaran = Pelanggaran::findOrFail($id);
        $pelanggaran->update($data);
        return $data;
    }

    public function delete(int $id)
    {
        return Pelanggaran::findOrFail($id)->delete();
    }

    public function search(string $keyword)
    {
        return Pelanggaran::with([
            'siswa:id,nama,kelas_id,nis',
            'guru:id,nama_guru',
            'siswa.kelas:id,nama_kelas',
            'jenisPelanggaran:id,nama_pelanggaran,tingkat_pelanggaran_id,poin'
        ])->whereHas('siswa', function ($q) use ($keyword) {
            $q->where('nama', 'LIKE', '%' . $keyword . '%');
            $q->orWhere('nis', 'LIKE', '%' . $keyword . '%');
        })->latest()->get();
    }

    public function sendMessages($nomorWali, $namaSiswa, $totalPoin, $tahap)
    {

        $message = "Assalamu’alaikum Warahmatullahi Wabarakatuh.\n\n" .
            "Pemberitahuan dari SIPESDA MTs Da'il Khairaat.\n\n" .
            "Menginformasikan bahwa saat ini siswa atas nama *{$namaSiswa}*, berada di *{$tahap}* dikarenakan akumulasi poin pelanggaran sebesar *{$totalPoin}*.\n\n" .
            "Mohon Bapak/Ibu Wali Murid dapat memberikan perhatian lebih serta bimbingan kepada ananda di rumah agar tidak melakukan pelanggaran tambahan yang dapat mengakibatkan konsekuensi lebih lanjut.\n\n" .
            "Atas perhatian dan kerjasamanya, kami ucapkan terima kasih.\n\n" .
            "Wassalamu’alaikum Warahmatullahi Wabarakatuh.";

        return $whatsappUrl = "https://wa.me/" . $nomorWali . "?text=" . urlencode($message);
    }
}
