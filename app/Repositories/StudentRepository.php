<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
use App\Enums\Network;
use App\Imports\StudentsImport;

class StudentRepository extends BaseRepository
{
    public function getModel()
    {
        return Student::class;
    }

    public function filter(array $data)
    {
        $query = $this->model->with('user', 'subjects');

        if (isset($data['status'])) {
            $query->where('status', $data['status']);
        }
        if (isset($data['age_from'])) {
            $dateFrom = Carbon::now()->subYears($data['age_from'])->startOfDay()->toDateString();
            $query->where('birthday', '<=', $dateFrom);
        }
        if (isset($data['age_to'])) {
            $dateTo = Carbon::now()->subYears($data['age_to'])->endOfDay()->toDateString();;
            $query->where('birthday', '>=', $dateTo);
        }
        if (isset($data['score_from']) || isset($data['score_to'])) {
            $query->whereHas('subjects', function ($query) use ($data) {
                $query->select(DB::raw('AVG(score) as avg_score'))
                    ->groupBy('student_id');

                if (isset($data['score_from'])) {
                    $query->having('avg_score', '>=', $data['score_from']);
                }
                if (isset($data['score_to'])) {
                    $query->having('avg_score', '<=', $data['score_to']);
                }
            });
        }
        if (isset($data['network'])) {
            $networkEnum = Network::from($data['network']);
            switch ($networkEnum) {
                case Network::VINAPHONE:
                    $query->whereRaw("phone REGEXP '^081|^082|^083|^084|^085'");
                    break;
                case Network::VIETTEL:
                    $query->whereRaw("phone REGEXP '^032|^033|^034|^035|^036|^037|^038|^039|^099|^097|^098|^086'");
                    break;
                case Network::MOBIFONE:
                    $query->whereRaw("phone REGEXP '^070|^076|^077|^078|^079'");
                    break;
                default:
                    break;
            }
        }
        return $query->paginate($data['size'] ?? 10);
    }

    public function updateStudent($data, $id)
    {
        $student = $this->model->findOrFail($id);
        return $student->update($data);
    }

    public function show($id)
    {
        return $this->model->with('user', 'department', 'subjects')->findOrFail($id);
    }

    public function getScoreByStudentSubjectId($studentId, $subjectId)
    {
        $student = $this->model->with(['subjects' => function ($query) use ($subjectId) {
            $query->where('subjects.id', $subjectId);
        }])->findOrFail($studentId);

        $subject = $student->subjects->first();

        if ($subject) {
            return $subject->pivot->score;
        } else {
            return null;
        }
    }

    public function updateScore($studentId, $scores)
    {
        foreach ($scores as $subjectId => $score) {
            $student = $this->model->with(['subjects' => function ($query) use ($subjectId) {
                $query->where('subjects.id', $subjectId);
            }])->findOrFail($studentId);
            $student->subjects()->updateExistingPivot($subjectId, ['score' => $score]);
        }
        return $student;
    }

    public function registerSubject($studentId, $subjectId)
    {
        $student = $this->model->findOrFail($studentId);
        $student->subjects()->attach($subjectId);
        if ($student->status == \App\Enums\Status::NOT_STUDIED_YET->value) {
            $student->update(['status' => 2]);
        }
        return $student;
    }
}
