<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TingkatPelanggaran extends Model
{
    use HasFactory;

    protected $table = "tingkat_pelanggaran";

    protected $fillable = [
        'tingkat',
        'nilai',
    ] ;

    public function jenisPelanggaran(){
        return $this->hasMany(JenisPelanggaran::class);
    }
}
