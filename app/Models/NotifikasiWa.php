<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NotifikasiWa extends Model
{
    protected $table = 'notifikasi_wa';

    protected $fillable = [
        'pelanggaran_id',
        'no_tujuan',
        'pesan',
        'status',
        'sent_at'
    ];

    protected $casts = [
        'sent_at' => 'datetime'
    ];

    public function pelanggaran(): BelongsTo
    {
        return $this->belongsTo(Pelanggaran::class);
    }
}
