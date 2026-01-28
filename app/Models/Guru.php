<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Guru extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'guru';
    protected $fillable = [
        'user_id',
        'nip',
        'nama_guru',
        'photo',
        'kelas_id',
        'no_hp',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function users(){
        return $this->belongsTo(User::class);
    }
}
