<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RankingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'tahap_id' => $this->tahap_id,
            'deskripsi' => $this->tahap->deskripsi,
            'nama_siswa' => $this->siswa->nama ?? 'Siswa Terhapus',
            'tahap' => $this->tahap->nama ?? '-',
            'nilai_preferensi' => $this->nilai_preferensi,
        ];
    }
}
