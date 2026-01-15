<?php
namespace App\Repository;

use App\Models\BobotRules;
use App\Models\HasilSaw;
use App\Models\Pelanggaran;

class HasilSawRepository
{
    public function getBobotRule(int $thpId, int $krtId)
    {
        return BobotRules::where('tahap_id', $thpId)->where('kriteria_id', $krtId)->value('bobot');
    }

    public function normalisasiPoin(int $siswaId)
    {
        $jumlahPoinSiswa = Pelanggaran::where('siswa_id', $siswaId)->sum('poin');
        $normalisasiC1 = $jumlahPoinSiswa / 100;
        return $normalisasiC1;
    }

    public function normalisasiFreq(int $siswaId)
    {
        $kriteriaFrekuensiSiswa = Pelanggaran::where('siswa_id', $siswaId)->count();
        $normalisasiC2 = $kriteriaFrekuensiSiswa / 10;
        return $normalisasiC2;
    }

    public function normalisasiTingkat(int $siswaId)
    {
        $kriteriaTingkat = Pelanggaran::where('siswa_id', $siswaId)->whereHas('jenisPelanggaran.tingkatPelanggaran')->get()->sum(function ($pelanggaran) {
            return $pelanggaran->jenisPelanggaran->tingkatPelanggaran->nilai ?? 0;
        });
        $kriteriaFrekuensiSiswa = Pelanggaran::where('siswa_id', $siswaId)->count();

        $normalisasiC3 = $normalisasiC3 = ($kriteriaTingkat / $kriteriaFrekuensiSiswa) / 3;

        return $normalisasiC3;
    }

    public function nilaiPreferensiTahap1(int $siswaId, int $thpId, int $krtId)
    {
        // Ambil bobot untuk tindakan Tahap 1
        $bobotC1 = $this->getBobotRule(1, 1);
        $bobotC2 = $this->getBobotRule(1, 2);
        $bobotC3 = $this->getBobotRule(1, 3);

        $normalisasiC1 = $this->normalisasiPoin($siswaId);
        $normalisasiC2 = $this->normalisasiFreq($siswaId);
        $normalisasiC3 = $this->normalisasiTingkat($siswaId);

        $nilaiPreferensiTahap1
    }
}