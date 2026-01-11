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

    protected $appends = ['bobot'];

    public function getBobotAttribute()
    {
        return match ($this->kategori) {
            'rendah' => 1,
            'sedang' => 2,
            'berat' => 3,
            default => 0
        };
    }

    public function pelanggaran()
    {
        return $this->hasMany(Pelanggaran::class);
    }

    public function tingkatPelanggaran()
    {
        return $this->hasMany(TingkatPelanggaran::class);
    }
}
