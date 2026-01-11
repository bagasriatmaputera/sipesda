<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisPelanggaran extends Model
{
    protected $table = 'jenis_pelanggaran';

    protected $fillable = [
        'nama_pelanggaran',
        'tingkat_pelanggaran_id',
        'poin'
    ];

    public function pelanggaran()
    {
        return $this->hasMany(Pelanggaran::class);
    }

    public function tingkatPelanggaran()
    {
        return $this->belongsTo(TingkatPelanggaran::class, 'tingkat_pelanggaran_id');
    }
}
