<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BobotRuleResoruce extends JsonResource
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
            'kode_tahap' => $this->tahap->kode,
            'kode_kriteria' => $this->kriteria->kode,
            'bobot' => $this->bobot
        ];
    }
}
