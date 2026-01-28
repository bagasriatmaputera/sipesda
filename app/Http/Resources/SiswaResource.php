<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SiswaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            'nama' => $this->nama,
            'nis' => $this->nis,
            'kelas' => $this->kelas->nama_kelas ?? 'Tanpa Kelas',
            'nama_wali' => $this->nama_wali,
            'no_hp_wali' => $this->no_hp_wali,

            'pelanggaran' => $this->whenLoaded('pelanggaran', function () {
                return $this->pelanggaran->map(function ($p) {
                    return [
                        'id' => $p->id,
                        'tanggal' => $p->tanggal,
                        'poin' => $p->poin,
                        'keterangan' => $p->keterangan,
                        'guru' => [
                            'id' => $p->guru->id ?? null,
                            'nama' => $p->guru->nama_guru ?? null,
                        ],
                        'jenis_pelanggaran' => [
                            'id' => $p->jenisPelanggaran->id ?? null,
                            'nama' => $p->jenisPelanggaran->nama_pelanggaran ?? null,
                            'tingkat' => $p->jenisPelanggaran->tingkatPelanggaran->tingkat ?? null,
                            'nilai_pelanggaran' => $p->jenisPelanggaran->tingkatPelanggaran->nilai ?? null,
                        ]
                    ];
                });
            }),

            'saw' => $this->whenLoaded('hasilSaw', function () {
                return $this->hasilSaw->map(function ($s) {
                    return [
                        'id' => $s->id,
                        'tahap' => [
                            'Tahapan' => $s->tahap->nama ?? null,
                            'deskripsi' => $s->tahap->deskripsi ?? null,
                        ],
                        'kriteria' => [
                            'c1_poin' => $s->nilai_c1,
                            'c2_frekuensi' => $s->nilai_c2,
                            'c3_tingkat' => $s->nilai_c3,
                        ],
                        'normalisasi' => [
                            'c1' => (float) $s->normalisasi_c1,
                            'c2' => (float) $s->normalisasi_c2,
                            'c3' => (float) $s->normalisasi_c3,
                        ],
                        'nilai_preferensi' => (float) $s->nilai_preferensi,
                        'periode' => $s->periode,
                        'dibuat_pada' => $s->created_at->format('Y-m-d H:i:s'),
                        'diupdate_pada' => $s->updated_at->format('Y-m-d H:i:s'),
                    ];
                });
            }),
        ];
    }
}
