<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HasilSaw extends Model
{
    protected $fillable = [
        'siswa_id',
        'tahap_id',
        'nilai_c1',
        'nilai_c2',
        'nilai_c3',
        'normalisasi_c1',
        'normalisasi_c2',
        'normalisasi_c3',
        'nilai_preferensi',
        'periode'
    ];

    public function siswa(){
        return $this->belongsTo(Siswa::class);
    }

    public function tahap(){
        return $this->belongsTo(Tahap::class);
    }
}
