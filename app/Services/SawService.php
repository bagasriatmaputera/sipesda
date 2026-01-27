<?php
namespace App\Services;

use App\Repository\SawRepository;

class SawService
{
    public function __construct(protected SawRepository $sawRepo)
    {
    }

    public function getAlltahap(){
        return $this->sawRepo->getAllTahap();
    }

}