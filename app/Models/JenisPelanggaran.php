<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisPelanggaran extends Model
{
    protected $table = 'jenis_pelanggaran';

    protected $fillable = [
        'nama_pelanggaran',
        'kategori',
        'poin'
    ];

    public function pelanggaran()
    {
        return $this->hasMany(Pelanggaran::class);
    }
}
