<?php

namespace App\Imports;

use App\Models\Student;
use App\Models\Subject;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
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
        $studentCodes = $rows->pluck('ma_sinh_vien')->unique();
        $students = Student::whereIn('student_code', $studentCodes)->with('subjects')->get();

        $upsertData = [];
        $studentCodeToIdMap = $students->pluck('id', 'student_code');

        foreach ($rows as $row) {
            if (empty($row['ma_sinh_vien']) || empty($row['id_mon_hoc'])) {
                $this->errors[] = "Student code or Subject ID is missing.";
                return;
            }

            $upsertData[] = [
                'student_id' => $studentCodeToIdMap->get($row['ma_sinh_vien']),
                'subject_id' => $row['id_mon_hoc'],
                'score' => $row['diem_mon_hoc'],
                'updated_at' => Carbon::now(),
            ];
        }

        if (count($upsertData) > 0) {
            DB::table('student_subject')
                ->upsert($upsertData, ['student_id', 'subject_id'], ['score']);
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
