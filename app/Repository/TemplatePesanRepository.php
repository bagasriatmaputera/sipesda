<?php

namespace App\Repository;

use App\Models\TemplatePesan;

class TemplatePesanRepository
{
    public function getAll()
    {
        return TemplatePesan::latest()->get();
    }

    public function getActive()
    {
        return TemplatePesan::where('aktif', true)->first();
    }

    public function create(array $data)
    {
        return TemplatePesan::create($data);
    }

    public function update(int $id, array $data)
    {
        $template = TemplatePesan::findOrFail($id);
        $template->update($data);
        return $template;
    }

    public function delete(int $id)
    {
        return TemplatePesan::findOrFail($id)->delete();
    }
}
