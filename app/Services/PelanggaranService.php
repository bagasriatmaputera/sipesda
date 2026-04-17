<?php

namespace App\Services;

use App\Models\BobotRules;
use App\Models\HasilSaw;
use App\Models\InformasiPelanggaranSiswa;
use App\Models\JenisPelanggaran;
use App\Models\Pelanggaran;
use App\Repository\PelanggaranRepository;
use App\Repository\SawRepository;
use Illuminate\Support\Facades\DB;

class PelanggaranService
{
    public function __construct(
        protected PelanggaranRepository $repository,
        protected SawRepository $hasilSawRepo
    ) {
    }

    public function getAll(?string $keyword = '')
    {
        return $this->repository->getAll($keyword);
    }

    public function create(array $request)
    {
        return DB::transaction(function () use ($request) {
            $isBulk = isset($request[0]) && is_array($request[0]);
            $payloads = $isBulk ? $request : [$request];

            $results = [];

            foreach ($payloads as $data) {

                $jenis = JenisPelanggaran::findOrFail($data['jenis_pelanggaran_id']);

                $newViolation = $this->repository->create([
                    'siswa_id' => $data['siswa_id'],
                    'guru_id' => $data['guru_id'],
                    'jenis_pelanggaran_id' => $data['jenis_pelanggaran_id'],
                    'keterangan' => $data['keterangan'],
                    'poin' => $jenis->poin,
                    'tanggal' => now()

                ]);

                // SAW Property
                $nilaiData = $this->hasilSawRepo->getNilaiNormalisasi($data['siswa_id']);
                $nilaiPreferensi = $this->hasilSawRepo->getAllNilaiPreferensi($data['siswa_id']);
                $totalPoin = $nilaiData['nilai_c1'];

                // Method SAW - Loop untuk update or create semua tahap dengan validasi
                foreach ($nilaiPreferensi as $tahapId => $nilaiPref) {
                    // Validasi tahap berdasarkan total poin
                    if (!$this->canRecommendTahap($tahapId, $totalPoin)) {
                        continue;
                    }

                    HasilSaw::updateOrCreate(
                        [
                            'siswa_id' => $data['siswa_id'],
                            'tahap_id' => $tahapId,
                            'periode' => $this->getPeriodeTahunAjaran(),
                        ],
                        [
                            'nilai_c1' => $nilaiData['nilai_c1'],
                            'nilai_c2' => $nilaiData['nilai_c2'],
                            'nilai_c3' => $nilaiData['nilai_c3'],
                            'normalisasi_c1' => $nilaiData['normalisasi_c1'],
                            'normalisasi_c2' => $nilaiData['normalisasi_c2'],
                            'normalisasi_c3' => $nilaiData['normalisasi_c3'],
                            'nilai_preferensi' => $nilaiPref,
                        ]
                    );
                }

                $results[] = $newViolation;

            }
            return $isBulk ? $results : $results[0];
        });
    }

    private function getPeriodeTahunAjaran()
    {
        $bulan = now()->month;
        $tahun = now()->year;

        if ($bulan >= 7) {
            return $tahun . '/' . ($tahun + 1);
        } else {
            return ($tahun - 1) . '/' . $tahun;
        }
    }

    private function canRecommendTahap(int $tahapId, int $totalPoin): bool
    {
        return match ($tahapId) {
            // Tahap 1-2: Tanpa syarat minimum
            1, 2 => true,
            // Tahap 3: Minimum poin 50
            3 => $totalPoin >= 50,
            // Tahap 4: Minimum poin 70
            4 => $totalPoin >= 70,
            // Tahap 5: Minimum poin 100
            5 => $totalPoin >= 100,
            default => false,
        };
    }

    public function update(int $id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            $pelanggaran = Pelanggaran::where('id', $id)->first();
            if (!$pelanggaran) {
                throw new \Exception('Data tidak ada');
            }

            try {
                // Pelanggaran
                return DB::transaction(function () use ($data, $pelanggaran) {
                    $besarPoin = JenisPelanggaran::select(['id', 'poin'])
                        ->where('id', $data['jenis_pelanggaran_id'])->first();
                    $pelanggaran->update([
                        'guru_id' => $data['guru_id'],
                        'jenis_pelanggaran_id' => $data['jenis_pelanggaran_id'],
                        'keterangan' => $data['keterangan'],
                        'poin' => $besarPoin->poin,
                        'tanggal' => $data['tanggal'],
                    ]);
                    
                    $siswaId = $pelanggaran->siswa_id;
                    
                    // Get nilai dan normalisasi dari SawRepository
                    $nilaiData = $this->hasilSawRepo->getNilaiNormalisasi($siswaId);
                    $nilaiPreferensi = $this->hasilSawRepo->getAllNilaiPreferensi($siswaId);
                    $totalPoin = $nilaiData['nilai_c1'];

                    // Loop untuk update or create semua tahap dengan validasi
                    foreach ($nilaiPreferensi as $tahapId => $nilaiPref) {
                        // Validasi tahap berdasarkan total poin
                        if (!$this->canRecommendTahap($tahapId, $totalPoin)) {
                            continue;
                        }

                        HasilSaw::updateOrCreate(
                            [
                                'siswa_id' => $siswaId,
                                'tahap_id' => $tahapId,
                                'periode' => $this->getPeriodeTahunAjaran(),
                            ],
                            [
                                'nilai_c1' => $nilaiData['nilai_c1'],
                                'nilai_c2' => $nilaiData['nilai_c2'],
                                'nilai_c3' => $nilaiData['nilai_c3'],
                                'normalisasi_c1' => $nilaiData['normalisasi_c1'],
                                'normalisasi_c2' => $nilaiData['normalisasi_c2'],
                                'normalisasi_c3' => $nilaiData['normalisasi_c3'],
                                'nilai_preferensi' => $nilaiPref,
                            ]
                        );
                    }
                    return $pelanggaran;

                });
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

    private function refreshSiswaSawData(int $siswaId)
    {
        // Ambil nilai dan normalisasi dari SawRepository
        $nilaiData = $this->hasilSawRepo->getNilaiNormalisasi($siswaId);
        $nilaiPreferensi = $this->hasilSawRepo->getAllNilaiPreferensi($siswaId);
        $totalPoin = $nilaiData['nilai_c1'];

        // Loop untuk update or create semua tahap dengan validasi
        foreach ($nilaiPreferensi as $tahapId => $nilaiPref) {
            // Validasi tahap berdasarkan total poin
            if (!$this->canRecommendTahap($tahapId, $totalPoin)) {
                continue;
            }

            HasilSaw::updateOrCreate(
                [
                    'siswa_id' => $siswaId,
                    'tahap_id' => $tahapId,
                    'periode' => $this->getPeriodeTahunAjaran(),
                ],
                [
                    'nilai_c1' => $nilaiData['nilai_c1'],
                    'nilai_c2' => $nilaiData['nilai_c2'],
                    'nilai_c3' => $nilaiData['nilai_c3'],
                    'normalisasi_c1' => $nilaiData['normalisasi_c1'],
                    'normalisasi_c2' => $nilaiData['normalisasi_c2'],
                    'normalisasi_c3' => $nilaiData['normalisasi_c3'],
                    'nilai_preferensi' => $nilaiPref,
                ]
            );
        }
    }

    public function delete(int $id)
    {
        return DB::transaction(function () use ($id) {
            $pelanggaran = Pelanggaran::findOrFail($id);
            $siswaId = $pelanggaran->siswa_id;

            try {
                $this->repository->delete($id);

                $this->refreshSiswaSawData($siswaId);

                return true;
            } catch (\Throwable $th) {
                throw new \Exception('Gagal menghapus dan update SAW: ' . $th->getMessage());
            }
        });
    }

    public function search(string $keyword)
    {
        return $this->repository->search($keyword);
    }
}
