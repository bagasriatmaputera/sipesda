<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BobotRules extends Model
{
    use HasFactory;

    protected $fillable = [
        'tahap_id',
        'kriteria_id',
        'bobot'

    ];

    public function tahap()
    {
        return $this->belongsTo(Tahap::class);
    }

    public function kriteria(){
        return $this->belongsTo(Kriteria::class,'kriteria_id');
    }
}
