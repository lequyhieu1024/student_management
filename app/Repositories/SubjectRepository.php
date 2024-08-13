<?php

namespace App\Repositories;

use App\Models\Subject;

class SubjectRepository extends BaseRepository
{
    public function getModel()
    {
        return Subject::class;
    }

    public function getSubjectHasScores()
    {
        return $this->model->whereHas('students', function ($query) {
            $query->whereNotNull('score');
        })->pluck('id');
    }
    public function getSubjectHasScore($id)
    {
        return $this->model->whereHas('students', function ($query) {
            $query->whereNotNull('score');
        })->where('id', $id)->exists();
    }
    public function deleteSubject($id)
    {
        $subject = $this->model->findOrFail($id);
        $subject->students()->detach();
        $subject->delete();
    }
    public function getSubjectDoesntHasStudent($id)
    {
        return $this->model->whereDoesntHave('students', function ($query) use ($id) {
            $query->where('student_id', $id);
        })->pluck('name', 'id');
    }
    public function getSubjectByStudentId($studentId)
    {
        return $this->model->whereHas('students', function ($query) use ($studentId) {
            $query->where('student_id', $studentId);
        })->get();
    }
}
