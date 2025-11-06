<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Attendance;
use Carbon\Carbon;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create('ar_SA');

        // Ensure there are some teachers
        if (Teacher::count() < 5) {
            for ($i = 1; $i <= 5; $i++) {
                Teacher::create([
                    'name' => $faker->name,
                    'qualification' => $faker->randomElement(['B.Ed', 'M.Ed', 'PhD']),
                    'subject' => $faker->randomElement(['رياضيات', 'لغة عربية', 'علوم', 'إنجليزي', 'تاريخ']),
                    'phone' => $faker->phoneNumber,
                    'home_phone' => $faker->phoneNumber,
                    'address' => $faker->address,
                ]);
            }
        }

        // Ensure there are some students
        if (Student::count() < 20) {
            for ($i = 1; $i <= 20; $i++) {
                Student::create([
                    'name' => $faker->name,
                    'status' => 'active',
                    'gender' => $faker->randomElement(['male','female']),
                    'photo' => null,
                    'address' => $faker->address,
                    'home_phone' => $faker->phoneNumber,
                    'mobile_phone' => $faker->phoneNumber,
                    'level' => $faker->numberBetween(1,12),
                    'major' => $faker->randomElement(['عام','تخصصي']),
                    'notes' => null,
                ]);
            }
        }

        $students = Student::all();
        $teachers = Teacher::all();

        $subjects = ['رياضيات', 'لغة عربية', 'علوم', 'إنجليزي', 'تاريخ'];
        $classes = ['A', 'B', 'C'];
        $statuses = ['حاضر', 'غائب', 'متأخر', 'مُعفى'];

        // Generate attendance for past 14 days
        for ($d = 0; $d < 14; $d++) {
            $date = Carbon::now()->subDays($d)->toDateString();

            foreach ($students as $student) {
                // Randomly skip some entries to simulate real data
                if (rand(0, 10) < 2) continue;

                $subject = $faker->randomElement($subjects);
                $class = $faker->randomElement($classes);
                $teacher = $teachers->random();
                $status = $faker->randomElement($statuses);
                $late_minutes = $status === 'متأخر' ? rand(1, 30) : null;
                $absence_reason = $status === 'غائب' ? $faker->sentence : null;

                Attendance::create([
                    'student_id' => $student->id,
                    'teacher_id' => $teacher->id,
                    'subject_name' => $subject,
                    'class_name' => $class,
                    'session_date' => $date,
                    'session_time' => $faker->time('H:i'),
                    'status' => $status,
                    'absence_reason' => $absence_reason,
                    'late_minutes' => $late_minutes,
                    'notes' => null,
                    'recorded_by' => rand(0,1) ? 'teacher' : 'admin'
                ]);
            }
        }
    }
}
