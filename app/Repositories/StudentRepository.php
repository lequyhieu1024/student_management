<?php 
namespace App\Repositories;

use App\Models\Student;

class StudentRepository extends BaseRepository{
    public function getModel(){
        return Student::class;
    }

    public function filter(array $q){
        return Student::join('users', 'users.id', '=', 'students.user_id')
            // ->where()
            ->select('students.*', 'users.name')
            ->paginate($q['pageSize']);
    }
}