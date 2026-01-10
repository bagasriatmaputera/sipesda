<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InformasiPelanggaranSiswa extends Model
{
    protected $table = 'informasi_pelanggaran_siswa';

    protected $fillable = [
        'siswa_id',
        'kelas_id',
        'poin_pelanggaran',
        'tahap'
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }
}
