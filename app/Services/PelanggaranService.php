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

    public function getAll(array $fields)
    {
        return $this->repository->getAll($fields);
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

                // $info = InformasiPelanggaranSiswa::firstOrCreate(
                //     ['siswa_id' => $data['siswa_id']],
                //     ['poin_pelanggaran' => 0, 'tahap' => 1]
                // );

                // $totalPoinBaru = $info->poin_pelanggaran + $jenis->poin;

                // $tahapBaru = $this->tentukanTahap($totalPoinBaru);

                // $info->update([
                //     'poin_pelanggaran' => $totalPoinBaru,
                //     'tahap' => $tahapBaru
                // ]);

                // SAW Property
                $nilaiC1 = $this->hasilSawRepo->getPoin($data['siswa_id']);
                $nilaiC2 = $this->hasilSawRepo->getFrequensi($data['siswa_id']);
                $nilaiC3 = $this->hasilSawRepo->getTotalTingkatPelanggaran($data['siswa_id']);

                $normalisasiPoinC1 = $this->hasilSawRepo->normalisasiPoin($data['siswa_id']);
                $normalisaisFrequensiC2 = $this->hasilSawRepo->normalisasiFreq($data['siswa_id']);
                $normalisasiTingkatC3 = $this->hasilSawRepo->normalisasiTingkat($data['siswa_id']);

                // nilai preferensi per tahap
                $nilaiPreferensiTahap1 = $this->hasilSawRepo->nilaiPreferensiTahap1($data['siswa_id'] );
                $nilaiPreferensiTahap2 = $this->hasilSawRepo->nilaiPreferensiTahap2( $data['siswa_id'] );
                $nilaiPreferensiTahap3 = $this->hasilSawRepo->nilaiPreferensiTahap3( $data['siswa_id'] );
                $nilaiPreferensiTahap4 = $this->hasilSawRepo->nilaiPreferensiTahap4( $data['siswa_id'] );
                $nilaiPreferensiTahap5 = $this->hasilSawRepo->nilaiPreferensiTahap5( $data['siswa_id'] );

                // Method SAW
                // Data untuk semua tahap
                $tahapData = [
                    1 => $nilaiPreferensiTahap1,
                    2 => $nilaiPreferensiTahap2,
                    3 => $nilaiPreferensiTahap3,
                    4 => $nilaiPreferensiTahap4,
                    5 => $nilaiPreferensiTahap5,
                ];

                // Loop untuk update or create semua tahap
                foreach ($tahapData as $tahapId => $nilaiPreferensi) {
                    HasilSaw::updateOrCreate(
                        [
                            'siswa_id' => $data['siswa_id'],
                            'tahap_id' => $tahapId,
                            'periode' => $this->getPeriodeTahunAjaran(),
                        ],
                        [
                            'nilai_c1' => $nilaiC1,
                            'nilai_c2' => $nilaiC2,
                            'nilai_c3' => $nilaiC3,
                            'normalisasi_c1' => $normalisasiPoinC1,
                            'normalisasi_c2' => $normalisaisFrequensiC2,
                            'normalisasi_c3' => $normalisasiTingkatC3,
                            'nilai_preferensi' => $nilaiPreferensi,
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
    private function tentukanTahap($poin)
    {
        if ($poin <= 30)
            return 1;
        if ($poin <= 50)
            return 2;
        if ($poin <= 75)
            return 3;
        if ($poin <= 100)
            return 4;
        return 5;
    }

    public function update(int $id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            $pelanggaran = Pelanggaran::where('id', $id)->first();
            if (!$pelanggaran) {
                throw new \Exception('Data tidak ada');
            }

            // $infoSiswa = InformasiPelanggaranSiswa::where('siswa_id', $pelanggaran->siswa_id)->first();

            // if (!$infoSiswa) {
            //     throw new \Exception('Data siswa tidak ada');
            // }

            // Kurangi Poin Pelanggaran Siswa
            // $poinNetral = $infoSiswa->poin_pelanggaran - $pelanggaran->poin;



            // $poinSekarang = $poinNetral + $besarPoin->poin;

            try {
                // Pelanggaran
                return DB::transaction(function () use ($data, $pelanggaran) {
                    $besarPoin = JenisPelanggaran::select(['id', 'poin'])
                        ->where('id', $data['jenis_pelanggaran_id'])->first();
                    $pelanggaran->update([
                        'guru_id' => $data['guru_id'],
                        'jenis_pelanggaran_id' => $data['jenis_pelanggaran_id'],
                        'keterangan' => $data['keterangan'],
                        'poin' => $besarPoin->poin
                    ]);
                    // Informasi Pelanggaran Siswa
                    // $infoSiswa->update([
                    //     'poin_pelanggaran' => $poinSekarang
                    // ]);

                    // Perhitungan SAW
                    // SAW Property
                    $jumlahPoinSiswa = Pelanggaran::where('siswa_id', $pelanggaran->siswa_id)->sum('poin');
                    $kriteriaFrekuensiSiswa = Pelanggaran::where('siswa_id', $pelanggaran->siswa_id)->count();
                    $kriteriaTingkatPelanggaran = Pelanggaran::where('siswa_id', $pelanggaran->siswa_id)
                        ->whereHas('jenisPelanggaran.tingkatPelanggaran')
                        ->get()
                        ->sum(function ($tingkat) {
                            return $tingkat->jenisPelanggaran->tingkatPelanggaran->nilai ?? 0;
                        });
                    // $maxFreqPelanggaran = Pelanggaran::select('siswa_id')
                    //     ->groupBy('siswa_id')
                    //     ->orderByRaw('COUNT(*) desc')
                    //     ->count();

                    $BT1K1 = BobotRules::where('tahap_id', 1)->where('kriteria_id', 1)->value('bobot');
                    $BT1K2 = BobotRules::where('tahap_id', 1)->where('kriteria_id', 2)->value('bobot');
                    $BT1K3 = BobotRules::where('tahap_id', 1)->where('kriteria_id', 3)->value('bobot');
                    $BT2K1 = BobotRules::where('tahap_id', 2)->where('kriteria_id', 1)->value('bobot');
                    $BT2K2 = BobotRules::where('tahap_id', 2)->where('kriteria_id', 2)->value('bobot');
                    $BT2K3 = BobotRules::where('tahap_id', 2)->where('kriteria_id', 3)->value('bobot');
                    $BT3K1 = BobotRules::where('tahap_id', 3)->where('kriteria_id', 1)->value('bobot');
                    $BT3K2 = BobotRules::where('tahap_id', 3)->where('kriteria_id', 2)->value('bobot');
                    $BT3K3 = BobotRules::where('tahap_id', 3)->where('kriteria_id', 3)->value('bobot');
                    $BT4K1 = BobotRules::where('tahap_id', 4)->where('kriteria_id', 1)->value('bobot');
                    $BT4K2 = BobotRules::where('tahap_id', 4)->where('kriteria_id', 2)->value('bobot');
                    $BT4K3 = BobotRules::where('tahap_id', 4)->where('kriteria_id', 3)->value('bobot');
                    $BT5K1 = BobotRules::where('tahap_id', 5)->where('kriteria_id', 1)->value('bobot');
                    $BT5K2 = BobotRules::where('tahap_id', 5)->where('kriteria_id', 2)->value('bobot');
                    $BT5K3 = BobotRules::where('tahap_id', 5)->where('kriteria_id', 3)->value('bobot');


                    //
                    // Normalisasi Kriteria
                    // dd($jumlahPoinSiswa);
                    $normalisasiC1 = $jumlahPoinSiswa / 100; //karena 100 maksimal poin siswa
                    $normalisasiC2 = $kriteriaFrekuensiSiswa / 10; // 10 adalah batas siswa melakukan pelanggaran
                    $normalisasiC3 = ($kriteriaTingkatPelanggaran / $kriteriaFrekuensiSiswa) / 3; //karena 3 Maksimal tingkat pelanggaran siswa

                    // nilai preferensi per tahap
                    $nilaiPreferensiTahap1 = (($normalisasiC1 * $BT1K1) + ($normalisasiC2 * $BT1K2) + ($normalisasiC3 * $BT1K3));
                    $nilaiPreferensiTahap2 = (($normalisasiC1 * $BT2K1) + ($normalisasiC2 * $BT2K2) + ($normalisasiC3 * $BT2K3));
                    $nilaiPreferensiTahap3 = (($normalisasiC1 * $BT3K1) + ($normalisasiC2 * $BT3K2) + ($normalisasiC3 * $BT3K3));
                    $nilaiPreferensiTahap4 = (($normalisasiC1 * $BT4K1) + ($normalisasiC2 * $BT4K2) + ($normalisasiC3 * $BT4K3));
                    $nilaiPreferensiTahap5 = (($normalisasiC1 * $BT5K1) + ($normalisasiC2 * $BT5K2) + ($normalisasiC3 * $BT5K3));

                    // Method SAW
                    // Data untuk semua tahap
                    $tahapData = [
                        1 => $nilaiPreferensiTahap1,
                        2 => $nilaiPreferensiTahap2,
                        3 => $nilaiPreferensiTahap3,
                        4 => $nilaiPreferensiTahap4,
                        5 => $nilaiPreferensiTahap5,
                    ];

                    $siswaId = $pelanggaran->siswa_id;

                    // Loop untuk update or create semua tahap
                    foreach ($tahapData as $tahapId => $nilaiPreferensi) {
                        $test = HasilSaw::updateOrCreate(
                            [
                                'siswa_id' => $siswaId,
                                'tahap_id' => $tahapId,
                                'periode' => $this->getPeriodeTahunAjaran(),
                            ],
                            [
                                'nilai_c1' => $jumlahPoinSiswa,
                                'nilai_c2' => $kriteriaFrekuensiSiswa,
                                'nilai_c3' => $kriteriaTingkatPelanggaran,
                                'normalisasi_c1' => $normalisasiC1,
                                'normalisasi_c2' => $normalisasiC2,
                                'normalisasi_c3' => $normalisasiC3,
                                'nilai_preferensi' => $nilaiPreferensi,
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

    public function delete(int $id)
    {
        return DB::transaction(function () use ($id) {
            $pelanggaran = Pelanggaran::select(['id', 'siswa_id', 'poin'])->where('id', $id)->first();

            if (!$pelanggaran) {
                throw new \Exception('Data pelanggaran tidak ada.');
            }

            // $infoSiswa = InformasiPelanggaranSiswa::where('siswa_id', $pelanggaran->siswa_id)->first();
            try {
                $data = $this->repository->delete($id);
                // $infoSiswa->update([
                //     'poin_pelanggaran' => $infoSiswa->poin_pelanggaran -= $pelanggaran->poin,
                // ]);
                // return $infoSiswa;
            } catch (\Throwable $th) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed delete data, ' . $th->getMessage()
                ]);
            }
        });
    }
}
