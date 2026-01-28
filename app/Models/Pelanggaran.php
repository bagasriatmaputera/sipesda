<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pelanggaran extends Model
{
    protected $table = 'pelanggaran';

    protected $fillable = [
        'siswa_id',
        'guru_id',
        'jenis_pelanggaran_id',
        'tanggal',
        'poin',
        'keterangan'
    ];

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class)->withTrashed();
    }

    public function guru(): BelongsTo
    {
        return $this->belongsTo(Guru::class)->withTrashed();
    }

    public function jenisPelanggaran(): BelongsTo
    {
        return $this->belongsTo(JenisPelanggaran::class,'jenis_pelanggaran_id');
    }

    public function notifikasi(): BelongsTo
    {
        return $this->belongsTo(NotifikasiWa::class);
    }
}
