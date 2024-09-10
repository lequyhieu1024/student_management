<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class StudentsImport implements ToCollection, WithHeadingRow, WithValidation, WithChunkReading
{
    public $errors = [];

    /**
     * @param Collection $rows
     *
     * @return void
     */
    public function collection(Collection $rows)
    {
        // Split rows into chunks
        $chunkSize = $this->chunkSize();
        $chunks = $rows->chunk($chunkSize);

        foreach ($chunks as $chunk) {
            $this->processChunk($chunk);
        }
    }

    /**
     * Process a chunk of rows
     *
     * @param Collection $rows
     * @return void
     */
    private function processChunk(Collection $rows)
    {
        $upsertData = [];
        foreach ($rows as $row) {
            if (empty($row['id_sinh_vien']) || empty($row['id_mon_hoc'])) {
                $this->errors[] = "Student code or Subject ID is missing.";
                continue;
            }

            $upsertData[] = [
                'student_id' => $row['id_sinh_vien'],
                'subject_id' => $row['id_mon_hoc'],
                'score' => $row['diem_mon_hoc'],
            ];
        }

        if (count($upsertData) > 0) {
            DB::table('student_subject')
                ->upsert($upsertData, ['student_id', 'subject_id'], ['score']);
        }
    }

    /**
     * Define the chunk size
     *
     * @return int
     */
    public function chunkSize(): int
    {
        return 500;
    }

    public function rules(): array
    {
        return [
            'id_sinh_vien' => 'required',
            'id_mon_hoc' => 'required|numeric',
            'diem_mon_hoc' => 'required|numeric',
        ];
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
