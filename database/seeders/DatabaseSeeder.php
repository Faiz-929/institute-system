<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\AttendanceSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // إنشاء مستخدمين للمعلمين
        $this->call([
            UserSeeder::class,
            SubjectSeeder::class,
            GradeSeeder::class,
            StudentSeeder::class,
            AttendanceSeeder::class,
        ]);
    }
}
