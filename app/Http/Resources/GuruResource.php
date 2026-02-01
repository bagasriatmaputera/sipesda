<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GuruResource extends JsonResource
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
            'user_id' => new UserResource($this->whenLoaded('users')) ?? null,
            'nip' => $this->nip,
            'nama'=> $this->nama_guru,
            'kelas'=> new KelasResource($this->whenLoaded('kelas')) ?? null,
            'no_hp'=> $this->no_hp,
            'photo' => $this->photo ?? null,
        ];
    }
}
