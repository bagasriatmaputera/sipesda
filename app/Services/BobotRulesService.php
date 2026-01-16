<?php 
namespace App\Services;

use App\Repository\BobotRuleRepository;

class BobotRulesService {
    public function __construct(protected BobotRuleRepository $bobotRepo){}

    public function getAll(){
        return $this->bobotRepo->getAll();
    }

    public function getById($id){
        return $this->bobotRepo->getById($id);
    }

    public function create(array $data){
        return $this->bobotRepo->create($data);
    }

    public function update(int $id, array $data){
        return $this->bobotRepo->update($id, $data);
    }

    public function delete(int $id){
        return $this->bobotRepo->delete($id);
    }
}