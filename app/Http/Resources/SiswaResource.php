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
            'nama' => $this->nama,
            'nis' => $this->nis,
            'kelas' => $this->whenLoaded('kelas', function () {
                return $this->kelas->nama_kelas;
            }),
            'nama_wali' => $this->nama_wali,
            'no_hp_wali' => $this->no_hp_wali
        ];
    }
}
