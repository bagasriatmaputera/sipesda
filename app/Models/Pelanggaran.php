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
        return $this->belongsTo(Siswa::class);
    }

    public function guru(): BelongsTo
    {
        return $this->belongsTo(User::class, 'guru_id');
    }

    public function jenisPelanggaran(): BelongsTo
    {
        return $this->belongsTo(JenisPelanggaran::class);
    }

    public function notifikasi(): BelongsTo
    {
        return $this->belongsTo(NotifikasiWa::class);
    }
}
