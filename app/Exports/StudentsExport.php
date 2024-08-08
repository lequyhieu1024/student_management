<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class StudentsExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return collect([
            ['ST001', 1, 85],
            ['ST001', 2, 90],
            ['ST001', 3, 78],
            ['ST002', 1, 88],
            ['ST002', 3, 84],
            ['ST003', 2, 76],
            ['ST003', 4, 82],
        ]);
    }

    public function headings(): array
    {
        return [
            'student_code' => 'Mã Sinh Viên',
            'subject_id' => 'ID Môn Học',
            'score' => 'Điểm Môn Học',
        ];
    }
}
