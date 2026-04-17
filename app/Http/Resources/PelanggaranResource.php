<?php

namespace App\Http\Resources;

use App\Models\TingkatPelanggaran;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PelanggaranResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    private function getValidNumber($number) {
            $number = preg_replace('/[^0-9]/', '', $number);

            if (str_starts_with($number, '0')) {
                $number = '62' . substr($number, 1);
            } 
            elseif (str_starts_with($number, '8')) {
                $number = '62' . $number;
            }

            return $number;
                }

    public function toArray(Request $request): array
    {
        
            
        return [
            'id' => $this->id,
            'tanggal' => $this->tanggal,
            'poin' => $this->poin,
            'keterangan' => $this->keterangan,

            'siswa' => [
                'id' => $this->siswa->id ?? null,
                'nama' => $this->siswa->nama ?? 'Siswa Terhapus',
                'kelas' => $this->siswa->kelas->nama_kelas ?? null,
                'no_wali' => $this->getValidNumber($this->siswa->no_hp_wali) ?? null,
            ],

            'guru' => [
                'id' => $this->guru->id ?? null,
                'nama' => $this->guru->nama_guru ?? 'Mantan Guru',
            ],

            'pelanggaran' => [
                'id' => $this->jenisPelanggaran->id ?? null,
                'nama' => $this->jenisPelanggaran->nama_pelanggaran ?? 'Jenis Terhapus',
                // Pastikan relasi tingkatPelanggaran sudah di-load agar tidak error
                'tingkat' => $this->jenisPelanggaran->tingkatPelanggaran->tingkat ?? null,
                'nilai_pelanggaran' => $this->jenisPelanggaran->tingkatPelanggaran->nilai ?? null,
            ],
        ];
    }
}
