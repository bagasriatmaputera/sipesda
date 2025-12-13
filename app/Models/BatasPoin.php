<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BatasPoin extends Model
{
    protected $table = 'batas_poin';

    protected $fillable = [
        'min_poin',
        'max_poin',
        'tindakan'
    ];
}
