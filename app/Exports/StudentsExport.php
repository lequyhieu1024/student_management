<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Faker\Factory as Faker;
use App\Models\Student;
class StudentsExport implements FromArray, WithHeadings, WithChunkReading
{
    private const SUBJECT_ID_MIN = 2;
    private const SUBJECT_ID_MAX = 12;
    private const SCORE_MIN = 1;
    private const SCORE_MAX = 10;
    private const TOTAL_ROWS = 2000;
    private const CHUNK_SIZE = 500;

    private $faker;
    private $studentIds;

    public function __construct()
    {
        $this->faker = Faker::create();
        $this->studentIds = Student::pluck('id')->toArray();
    }

    /**
     * Sinh dữ liệu và trả về dưới dạng mảng.
     *
     * @return array
     */
    public function array(): array
    {
        $data = [];

        // Sinh dữ liệu cho tất cả các dòng
        for ($i = 0; $i < self::TOTAL_ROWS; $i++) {
            $data[] = [
                $this->faker->randomElement($this->studentIds),
                $this->faker->numberBetween(self::SUBJECT_ID_MIN, self::SUBJECT_ID_MAX),
                $this->faker->numberBetween(self::SCORE_MIN, self::SCORE_MAX),
            ];
        }

        return $data;
    }

    /**
     * Hàm trả về tiêu đề cho các cột trong file Excel.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'student_id' => 'ID Sinh Viên',
            'subject_id' => 'ID Môn Học',
            'score' => 'Điểm Môn Học',
        ];
    }

    /**
     * Kích thước của mỗi chunk.
     *
     * @return int
     */
    public function chunkSize(): int
    {
        return self::CHUNK_SIZE;
    }
}
