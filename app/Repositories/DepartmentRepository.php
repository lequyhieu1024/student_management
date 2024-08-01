<?php 
namespace App\Repositories;

use App\Models\Department;

class DepartmentRepository extends BaseRepository{
    public function getModel(){
        return Department::class;
    }
    public function getNameAndIds(){
        return $this->model->pluck('name','id');
    }
}