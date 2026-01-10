<?php
namespace App\Repository;

use App\Models\HasilSaw;

class HasilSawRepository {
    public function store(array $data){
        return HasilSaw::create($data);
    }

    public function update(array $data,int $id){
        $saw = HasilSaw::find($id);
        $saw->update($data);
        return $saw;
    }
}