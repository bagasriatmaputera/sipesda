<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Siswa extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'siswa';

    protected $fillable = [
        'nis',
        'nama',
        'nama_wali',
        'photo',
        'no_hp_wali',
        'kelas_id',
    ];

    public function pelanggaran()
    {
        return $this->hasMany(Pelanggaran::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function hasilSaw(){
        return $this->hasMany(HasilSaw::class);
    }
}
