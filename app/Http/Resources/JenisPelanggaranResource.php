<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JenisPelanggaranResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=> $this->id,
            'nama_pelanggaran' => $this->nama_pelanggaran,
            'tingkat' => $this->tingkatPelanggaran->tingkat,
            'poin' => $this->poin
        ];
    }
}
