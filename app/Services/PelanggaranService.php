<?php

namespace App\Services;

use App\Models\InformasiPelanggaranSiswa;
use App\Models\JenisPelanggaran;
use App\Models\Pelanggaran;
use App\Repository\PelanggaranRepository;
use App\Models\Siswa;
use Illuminate\Support\Facades\DB;

class PelanggaranService
{
    public function __construct(
        protected PelanggaranRepository $repository
    ) {}

    public function getAll(array $fields)
    {
        return $this->repository->getAll($fields);
    }

    public function create(array $request)
    {
        return DB::transaction(function () use ($request) {
            // 1. Cek apakah input adalah Bulk (Array of Array) atau Single
            $isBulk = isset($request[0]) && is_array($request[0]);
            $payloads = $isBulk ? $request : [$request];

            $results = [];

            foreach ($payloads as $data) {
                $jenis = JenisPelanggaran::findOrFail($data['jenis_pelanggaran_id']);

                $newViolation = $this->repository->create([
                    'siswa_id' => $data['siswa_id'],
                    'guru_id' => $data['guru_id'],
                    'jenis_pelanggaran_id' => $data['jenis_pelanggaran_id'],
                    'poin' => $jenis->poin,
                    'tanggal' => now()

                ]);

                $info = InformasiPelanggaranSiswa::firstOrCreate(
                    ['siswa_id' => $data['siswa_id']],
                    ['poin_pelanggaran' => 0, 'tahap' => 1]
                );

                $totalPoinBaru = $info->poin_pelanggaran + $jenis->poin;

                $tahapBaru = $this->tentukanTahap($totalPoinBaru);

                $info->update([
                    'poin_pelanggaran' => $totalPoinBaru,
                    'tahap' => $tahapBaru
                ]);

                $results[] = $newViolation;
            }

            return $isBulk ? $results : $results[0];
        });
    }

    /**
     * Logika penentuan tahap sesuai gambar yang Anda berikan sebelumnya
     */
    private function tentukanTahap($poin)
    {
        if ($poin <= 30) return 1;
        if ($poin <= 50) return 2;
        if ($poin <= 75) return 3;
        if ($poin <= 100) return 4;
        return 5;
    }

    public function update(int $id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            $pelanggaran = Pelanggaran::where('id', $id)->first();

            if (!$pelanggaran) {
                throw new \Exception('Data tidak ada');
            }

            $infoSiswa = InformasiPelanggaranSiswa::where('siswa_id', $pelanggaran->siswa_id)->first();

            if (!$infoSiswa) {
                throw new \Exception('Data siswa tidak ada');
            }

            // Kurangi Poin Pelanggaran Siswa
            $poinNetral = $infoSiswa->poin_pelanggaran - $pelanggaran->poin;

            $besarPoin = JenisPelanggaran::select(['id', 'poin'])
                ->where('id', $data['jenis_pelanggaran_id'])->first();

            $poinSekarang = $poinNetral + $besarPoin->poin;

            try {
                // Pelanggaran
                $pelanggaran->update([
                    'guru_id' => $data['guru_id'],
                    'jenis_pelanggaran_id' => $data['jenis_pelanggaran_id'],
                    'keterangan' => $data['keterangan'],
                    'poin' => $besarPoin->poin
                ]);
                // Informasi Pelanggaran Siswa
                $infoSiswa->update([
                    'poin_pelanggaran' => $poinSekarang
                ]);
                return $pelanggaran;
            } catch (\Throwable $th) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed update data' . $th->getMessage()
                ]);
            }
        });
    }
    public function getById(int $pelanggaranId)
    {
        return $this->repository->getById($pelanggaranId);
    }

    public function getBySiswa(int $siswaId)
    {
        return $this->repository->getBySiswaId($siswaId);
    }

    public function delete(int $id)
    {
        return DB::transaction(function () use ($id) {
            $pelanggaran = Pelanggaran::select(['id', 'siswa_id', 'poin'])->where('id', $id)->first();

            if (!$pelanggaran) {
                throw new \Exception('Data pelanggaran tidak ada.');
            }

            $infoSiswa = InformasiPelanggaranSiswa::where('siswa_id', $pelanggaran->siswa_id)->first();
            try {
                $data = $this->repository->delete($id);
                $infoSiswa->update([
                    'poin_pelanggaran' => $infoSiswa->poin_pelanggaran -= $pelanggaran->poin,
                ]);
                return $infoSiswa;
            } catch (\Throwable $th) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed delete data, ' . $th->getMessage()
                ]);
            }
        });
    }
}
