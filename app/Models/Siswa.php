<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table = 'siswa';

    protected $fillable = [
        'nis',
        'nama',
        'kelas',
        'total_poin'
    ];

    public function orangTua()
    {
        return $this->hasOne(OrangTua::class);
    }

    public function pelanggaran()
    {
        return $this->hasMany(Pelanggaran::class);
    }
}
