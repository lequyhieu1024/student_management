<?php 
namespace App\Repositories;

use App\Models\Subject;

class SubjectRepository extends BaseRepository{
    public function getModel(){
        return Subject::class;
    }
}