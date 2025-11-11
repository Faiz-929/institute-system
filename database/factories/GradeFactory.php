<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Grade;
use App\Models\Student;
use App\Models\Subject;
use App\Models\User;

class GradeFactory extends Factory
{
    protected $model = Grade::class;

    public function definition()
    {
        return [
            'student_id' => Student::factory(),
            'subject_id' => Subject::factory(),
            'teacher_id' => User::factory(),
            'semester' => $this->faker->randomElement(['الأول', 'الثاني', 'الثالث', 'الرابع']),
            'year' => $this->faker->numberBetween(2023, 2025),
            
            // درجات عشوائية بين 0 و 100
            'homework1' => $this->faker->numberBetween(0, 100),
            'participation1' => $this->faker->numberBetween(0, 100),
            'written_exam1' => $this->faker->numberBetween(0, 100),
            'homework2' => $this->faker->numberBetween(0, 100),
            'participation2' => $this->faker->numberBetween(0, 100),
            'written_exam2' => $this->faker->numberBetween(0, 100),
            'midterm1' => $this->faker->numberBetween(0, 100),
            'homework3' => $this->faker->numberBetween(0, 100),
            'participation3' => $this->faker->numberBetween(0, 100),
            'written_exam3' => $this->faker->numberBetween(0, 100),
            'homework4' => $this->faker->numberBetween(0, 100),
            'participation4' => $this->faker->numberBetween(0, 100),
            'written_exam4' => $this->faker->numberBetween(0, 100),
            'final_exam' => $this->faker->numberBetween(0, 100),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Grade $grade) {
            // حساب المجموع بعد الإنشاء
            $grade->calculateTotal();
            $grade->save();
        });
    }

    public function passed()
    {
        return $this->state(function (array $attributes) {
            $total = $this->faker->numberBetween(50, 100);
            return [
                'final_exam' => $total,
                // توزيع الدرجات بحيث المجموع يكون بين 50-100
                'homework1' => $this->faker->numberBetween(30, 50),
                'participation1' => $this->faker->numberBetween(30, 50),
                'written_exam1' => $this->faker->numberBetween(30, 50),
                'homework2' => $this->faker->numberBetween(30, 50),
                'participation2' => $this->faker->numberBetween(30, 50),
                'written_exam2' => $this->faker->numberBetween(30, 50),
                'midterm1' => $this->faker->numberBetween(30, 50),
                'homework3' => $this->faker->numberBetween(30, 50),
                'participation3' => $this->faker->numberBetween(30, 50),
                'written_exam3' => $this->faker->numberBetween(30, 50),
                'homework4' => $this->faker->numberBetween(30, 50),
                'participation4' => $this->faker->numberBetween(30, 50),
                'written_exam4' => $this->faker->numberBetween(30, 50),
            ];
        });
    }

    public function failed()
    {
        return $this->state(function (array $attributes) {
            return [
                'final_exam' => $this->faker->numberBetween(0, 49),
                // توزيع الدرجات بحيث المجموع يكون أقل من 50
                'homework1' => $this->faker->numberBetween(0, 30),
                'participation1' => $this->faker->numberBetween(0, 30),
                'written_exam1' => $this->faker->numberBetween(0, 30),
                'homework2' => $this->faker->numberBetween(0, 30),
                'participation2' => $this->faker->numberBetween(0, 30),
                'written_exam2' => $this->faker->numberBetween(0, 30),
                'midterm1' => $this->faker->numberBetween(0, 30),
                'homework3' => $this->faker->numberBetween(0, 30),
                'participation3' => $this->faker->numberBetween(0, 30),
                'written_exam3' => $this->faker->numberBetween(0, 30),
                'homework4' => $this->faker->numberBetween(0, 30),
                'participation4' => $this->faker->numberBetween(0, 30),
                'written_exam4' => $this->faker->numberBetween(0, 30),
            ];
        });
    }
}