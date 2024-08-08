<?php

namespace App\Imports;

use App\Models\Student;
use App\Models\Subject;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class StudentsImport implements ToCollection, WithHeadingRow, WithValidation
{

    public $errors = [];
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection $rows)
    {
        // dd($rows);
        foreach ($rows as $row) {

            $studentCode = $row['ma_sinh_vien'];
            $subjectId = $row['id_mon_hoc'];
            $score = $row['diem_mon_hoc'];

            if (empty($studentCode) || empty($subjectId)) {
                $this->errors[] = "Student code or Subject ID is missing.";
                continue;
            }

            $student = Student::where('student_code', $studentCode)->first();

            if (!$student) {
                $this->errors[] = "Student with code $studentCode not found.";
                continue;
            }

            if (!Subject::find($subjectId)) {
                $this->errors[] = "Subject with ID $subjectId not found.";
                continue;
            }

            if (Subject::find($subjectId)) {
                $student->subjects()->syncWithoutDetaching([$subjectId => ['score' => $score]]);
            }
        }
    }
    public function rules(): array
    {
        return [
            'ma_sinh_vien' => 'required',
            'id_mon_hoc' => 'required|numeric',
            'diem_mon_hoc' => 'required|numeric',
        ];
    }
    public function getErrors()
    {
        return $this->errors;
    }
}
