<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeleteUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('students')
            ->where('id', '>=', 58)
            ->delete();

        // Xóa dữ liệu từ ID 58 trở đi trong bảng 'users'
        DB::table('users')
            ->where('id', '>=', 58)
            ->delete();
    }
}
