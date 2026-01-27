<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HasilSawResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'siswa' => [
                'id' => $this->siswa_id,
                'nama' => $this->siswa->nama
            ],
            'tahap' => [
                'Tahapan' => $this->tahap->nama,
                'deskripsi' => $this->tahap->deskripsi,
            ],

            'kriteria' => [
                'c1_poin' => $this->nilai_c1,
                'c2_frekuensi' => $this->nilai_c2,
                'c3_tingkat' => $this->nilai_c3,
            ],

            'normalisasi' => [
                'c1' => (float) $this->normalisasi_c1,
                'c2' => (float) $this->normalisasi_c2,
                'c3' => (float) $this->normalisasi_c3,
            ],

            'nilai_preferensi' => (float) $this->nilai_preferensi,
            'periode' => $this->periode,

            'dibuat_pada' => $this->created_at->format('Y-m-d H:i:s'),
            'diupdate_pada' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
