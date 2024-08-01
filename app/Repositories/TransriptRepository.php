<?php 
namespace App\Repositories;

use App\Models\Student;
use App\Models\Subject;

class TransriptRepository extends BaseRepository{

    protected $student;
    protected $subject;
    public function __construct(Student $student, Subject $subject){
        $this->student = $student;
        $this->subject = $subject;
    }
    public function getModel(){
    }
    public function getAllStudentHasSubject(){
        return $this->student->whereHas('subjects')->paginate(10);
    }

    public function getAllBySubject(){
        return $this->subject->with('students')->paginate(10);
    }
}