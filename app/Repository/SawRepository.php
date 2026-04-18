<?php
namespace App\Repository;

use App\Models\BobotRules;
use App\Models\HasilSaw;
use App\Models\Kriteria;
use App\Models\Pelanggaran;
use App\Models\Tahap;

class SawRepository
{
    public function getBobotRule(int $thpId, int $krtId)
    {
        return BobotRules::where('tahap_id', $thpId)->where('kriteria_id', $krtId)->value('bobot');
    }

    public function getPoin(int $siswaId)
    {
        return Pelanggaran::where('siswa_id', $siswaId)->sum('poin');
    }

    public function getMaxPoin()
    {
        return Pelanggaran::selectRaw('siswa_id, SUM(poin) as total')
            ->groupBy('siswa_id')
            ->orderByDesc('total')
            ->first()->total ?? 100;
    }

    public function getFrequensi(int $siswaId)
    {
        return Pelanggaran::where('siswa_id', $siswaId)->count();
    }

    public function getMaxFreq()
    {
        return Pelanggaran::selectRaw('siswa_id, COUNT(*) as total')
            ->groupBy('siswa_id')
            ->orderByDesc('total')
            ->first()->total ?? 10;
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
        $normalisasiC1 = $jumlahPoinSiswa / 100; // 100 adalah maksimal poin siswa
        return $normalisasiC1;
    }
    public function normalisasiFreq(int $siswaId)
    {
        $kriteriaFrekuensiSiswa = $this->getFrequensi($siswaId);
        $normalisasiC2 = $kriteriaFrekuensiSiswa / 10; // 10 adalah batas siswa melakukan pelanggaran
        return $normalisasiC2;
    }

    public function normalisasiTingkat(int $siswaId)
    {
        $kriteriaTingkat = $this->getTotalTingkatPelanggaran($siswaId);
        $kriteriaFrekuensiSiswa = Pelanggaran::where('siswa_id', $siswaId)->count();

        if ($kriteriaFrekuensiSiswa == 0) {
            return 0;
        }

        $normalisasiC3 = ($kriteriaTingkat / $kriteriaFrekuensiSiswa) / 3; // 3 adalah maksimal tingkat pelanggaran
        return $normalisasiC3;
    }

    public function nilaiPreferensiTahap1(int $siswaId)
    {
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
        $bobotC1 = $this->getBobotRule(5, 1);
        $bobotC2 = $this->getBobotRule(5, 2);
        $bobotC3 = $this->getBobotRule(5, 3);

        $normalisasiC1 = $this->normalisasiPoin($siswaId);
        $normalisasiC2 = $this->normalisasiFreq($siswaId);
        $normalisasiC3 = $this->normalisasiTingkat($siswaId);

        $nilaiPreferensiTahap5 = (($normalisasiC1 * $bobotC1) + ($normalisasiC2 * $bobotC2) + ($normalisasiC3 * $bobotC3));

        return $nilaiPreferensiTahap5;
    }

    public function getAllNilaiPreferensi(int $siswaId)
    {
        return [
            1 => $this->nilaiPreferensiTahap1($siswaId),
            2 => $this->nilaiPreferensiTahap2($siswaId),
            3 => $this->nilaiPreferensiTahap3($siswaId),
            4 => $this->nilaiPreferensiTahap4($siswaId),
            5 => $this->nilaiPreferensiTahap5($siswaId),
        ];
    }

    public function getNilaiNormalisasi(int $siswaId)
    {
        return [
            'nilai_c1' => $this->getPoin($siswaId),
            'nilai_c2' => $this->getFrequensi($siswaId),
            'nilai_c3' => $this->getTotalTingkatPelanggaran($siswaId),
            'normalisasi_c1' => $this->normalisasiPoin($siswaId),
            'normalisasi_c2' => $this->normalisasiFreq($siswaId),
            'normalisasi_c3' => $this->normalisasiTingkat($siswaId),
        ];
    }

    public function getAllTahap()
    {
        return Tahap::select(['id', 'nama', 'kode', 'deskripsi'])->get();
    }

    public function getByIdTahap(int $idTahap)
    {
        return Tahap::findOrFail($idTahap);
    }

    public function storeTahap(array $data)
    {
        return Tahap::create($data);
    }

    public function updateTahap(array $data, int $idTahap)
    {
        $tahap = Tahap::findOrFail($idTahap);
        return $tahap->update($data);
    }

    public function deleteTahap(int $idTahap)
    {
        $tahap = Tahap::find($idTahap);
        return $tahap->delete();
    }

    public function getAllKriteria()
    {
        return Kriteria::select(['id', 'kode', 'nama'])->get();
    }

    public function getByIdKriteria(int $idKriteria)
    {
        return Kriteria::findOrFail($idKriteria);
    }

    public function storeKriteria(array $data)
    {
        return Kriteria::create($data);
    }

    public function updateKriteria(array $data, int $idKriteria)
    {
        $kriteria = Kriteria::findOrFail($idKriteria);
        $kriteria->update($data);
        return $kriteria;
    }

    public function getAllHasilSaw()
    {
        return HasilSaw::with(['siswa', 'tahap'])->get();
    }

    public function rankingSaw()
    {
        return HasilSaw::with(['siswa', 'tahap'])
        ->where('nilai_preferensi', '>=', 0.50)
        ->orderBy('nilai_preferensi', 'desc')
        ->orderBy('tahap_id', 'desc')
        ->get()
        ->unique('siswa_id')
        ->values();
    }

    // BobotRules CRUD Functions
    public function getAllBobot()
    {
        return BobotRules::with(['tahap', 'kriteria'])->get();
    }

    public function getByIdBobot(int $idBobot)
    {
        return BobotRules::with(['tahap', 'kriteria'])->findOrFail($idBobot);
    }

    public function storeBobot(array $data)
    {
        // Check if combination already exists
        $exists = BobotRules::where('tahap_id', $data['tahap_id'])
            ->where('kriteria_id', $data['kriteria_id'])
            ->exists();

        if ($exists) {
            throw new \Exception('Kombinasi tahap dan kriteria sudah ada');
        }

        // Check total weight for the tahap
        $currentTotal = BobotRules::where('tahap_id', $data['tahap_id'])->sum('bobot');
        $newTotal = $currentTotal + $data['bobot'];

        if ($newTotal > 1.0) {
            throw new \Exception("Total bobot untuk tahap ini tidak boleh melebihi 1.0. Saat ini: {$currentTotal}, ditambah: {$data['bobot']}, total: {$newTotal}");
        }

        return BobotRules::create($data);
    }

    public function updateBobot(array $data, int $idBobot)
    {
        $bobot = BobotRules::findOrFail($idBobot);
        
        // Calculate new total for the tahap excluding current record
        $currentTotal = BobotRules::where('tahap_id', $bobot->tahap_id)
            ->where('id', '!=', $idBobot)
            ->sum('bobot');
        
        $newBobot = $data['bobot'] ?? $bobot->bobot;
        $newTotal = $currentTotal + $newBobot;

        if ($newTotal > 1.0) {
            throw new \Exception("Total bobot untuk tahap ini tidak boleh melebihi 1.0. Saat ini (tanpa record ini): {$currentTotal}, bobot baru: {$newBobot}, total: {$newTotal}");
        }

        $bobot->update($data);
        return $bobot;
    }

    public function deleteBobot(int $idBobot)
    {
        $bobot = BobotRules::findOrFail($idBobot);
        return $bobot->delete();
    }
}