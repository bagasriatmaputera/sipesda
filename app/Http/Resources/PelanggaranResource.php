<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PelanggaranResource extends JsonResource
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
            'tanggal' => $this->tanggal,
            'poin' => $this->poin,
            'keterangan' => $this->keterangan,

            // Mengoptimalkan objek Siswa
            'siswa' => [
                'id' => $this->siswa->id,
                'nama' => $this->siswa->nama,
                'kelas' => $this->siswa->kelas->nama_kelas ?? null,
            ],

            // Mengoptimalkan objek Guru
            'guru' => [
                'id' => $this->guru->id,
                'nama' => $this->guru->nama_guru,
            ],

            // Mengoptimalkan objek Jenis Pelanggaran
            'pelanggaran' => [
                'id' => $this->jenisPelanggaran->id,
                'nama' => $this->jenisPelanggaran->nama_pelanggaran,
                'kategori' => $this->jenisPelanggaran->kategori,
            ],
        ];
    }
}
