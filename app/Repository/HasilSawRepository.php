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

    public function getPoin(int $siswaId)
    {
        return Pelanggaran::where('siswa_id', $siswaId)->sum('poin');
    }

    public function getFrequensi(int $siswaId)
    {
        return Pelanggaran::where('siswa_id', $siswaId)->count();
    }

    public function getTotalTingkatPelanggaran(int $siswaId)
    {
        return Pelanggaran::where('siswa_id', $siswaId)->whereHas('jenisPelanggaran.tingkatPelanggaran')->get()->sum(function ($pelanggaran) {
            return $pelanggaran->jenisPelanggaran->tingkatPelanggaran->nilai ?? 0;
        });
    }
    public function normalisasiPoin(int $siswaId)
    {
        $jumlahPoinSiswa = $this->getPoin($siswaId);
        $normalisasiC1 = $jumlahPoinSiswa / 100;
        return $normalisasiC1;
    }
    public function normalisasiFreq(int $siswaId)
    {
        $kriteriaFrekuensiSiswa = $this->getFrequensi($siswaId);
        $normalisasiC2 = $kriteriaFrekuensiSiswa / 10;
        return $normalisasiC2;
    }

    public function normalisasiTingkat(int $siswaId)
    {
        $kriteriaTingkat = $this->getTotalTingkatPelanggaran($siswaId);
            $kriteriaFrekuensiSiswa = Pelanggaran::where('siswa_id', $siswaId)->count();

        $normalisasiC3 = $normalisasiC3 = ($kriteriaTingkat / $kriteriaFrekuensiSiswa) / 3;

        return $normalisasiC3;
    }

    public function nilaiPreferensiTahap1(int $siswaId)
    {
        // Ambil bobot untuk tindakan Tahap 1
        $bobotC1 = $this->getBobotRule(1, 1);
        $bobotC2 = $this->getBobotRule(1, 2);
        $bobotC3 = $this->getBobotRule(1, 3);

        $normalisasiC1 = $this->normalisasiPoin($siswaId);
        $normalisasiC2 = $this->normalisasiFreq($siswaId);
        $normalisasiC3 = $this->normalisasiTingkat($siswaId);

        $nilaiPreferensiTahap1 = (($normalisasiC1 * $bobotC1) + ($normalisasiC2 * $bobotC2) + ($normalisasiC3 * $bobotC3));

        return $nilaiPreferensiTahap1;
    }
    public function nilaiPreferensiTahap2(int $siswaId)
    {
        // Ambil bobot untuk tindakan Tahap 1
        $bobotC1 = $this->getBobotRule(2, 1);
        $bobotC2 = $this->getBobotRule(2, 2);
        $bobotC3 = $this->getBobotRule(2, 3);

        $normalisasiC1 = $this->normalisasiPoin($siswaId);
        $normalisasiC2 = $this->normalisasiFreq($siswaId);
        $normalisasiC3 = $this->normalisasiTingkat($siswaId);

        $nilaiPreferensiTahap2 = (($normalisasiC1 * $bobotC1) + ($normalisasiC2 * $bobotC2) + ($normalisasiC3 * $bobotC3));

        return $nilaiPreferensiTahap2;
    }
    public function nilaiPreferensiTahap3(int $siswaId)
    {
        // Ambil bobot untuk tindakan Tahap 1
        $bobotC1 = $this->getBobotRule(3, 1);
        $bobotC2 = $this->getBobotRule(3, 2);
        $bobotC3 = $this->getBobotRule(3, 3);

        $normalisasiC1 = $this->normalisasiPoin($siswaId);
        $normalisasiC2 = $this->normalisasiFreq($siswaId);
        $normalisasiC3 = $this->normalisasiTingkat($siswaId);

        $nilaiPreferensiTahap3 = (($normalisasiC1 * $bobotC1) + ($normalisasiC2 * $bobotC2) + ($normalisasiC3 * $bobotC3));

        return $nilaiPreferensiTahap3;
    }
    public function nilaiPreferensiTahap4(int $siswaId)
    {
        // Ambil bobot untuk tindakan Tahap 1
        $bobotC1 = $this->getBobotRule(4, 1);
        $bobotC2 = $this->getBobotRule(4, 2);
        $bobotC3 = $this->getBobotRule(4, 3);

        $normalisasiC1 = $this->normalisasiPoin($siswaId);
        $normalisasiC2 = $this->normalisasiFreq($siswaId);
        $normalisasiC3 = $this->normalisasiTingkat($siswaId);

        $nilaiPreferensiTahap4 = (($normalisasiC1 * $bobotC1) + ($normalisasiC2 * $bobotC2) + ($normalisasiC3 * $bobotC3));

        return $nilaiPreferensiTahap4;
    }
    public function nilaiPreferensiTahap5(int $siswaId)
    {
        // Ambil bobot untuk tindakan Tahap 1
        $bobotC1 = $this->getBobotRule(5, 1);
        $bobotC2 = $this->getBobotRule(5, 2);
        $bobotC3 = $this->getBobotRule(5, 3);

        $normalisasiC1 = $this->normalisasiPoin($siswaId);
        $normalisasiC2 = $this->normalisasiFreq($siswaId);
        $normalisasiC3 = $this->normalisasiTingkat($siswaId);

        $nilaiPreferensiTahap5 = (($normalisasiC1 * $bobotC1) + ($normalisasiC2 * $bobotC2) + ($normalisasiC3 * $bobotC3));

        return $nilaiPreferensiTahap5;
    }


}