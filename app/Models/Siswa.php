<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;
    protected $table = 'siswa';

    protected $fillable = [
        'nis',
        'nama',
        'nama_wali',
        'no_hp_wali',
        'kelas_id',
        'total_poin'
    ];

    public function pelanggaran()
    {
        return $this->hasMany(Pelanggaran::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }
}
