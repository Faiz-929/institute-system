<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    public function run(): void
    {
        $subjects = [
            [
                'name' => 'الرياضيات',
                'code' => 'MATH101',
                'description' => 'مادة الرياضيات الأساسية',
                'grade_level' => 'المستوى الأول',
                'credit_hours' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'العلوم',
                'code' => 'SCI101',
                'description' => 'مادة العلوم الطبيعية',
                'grade_level' => 'المستوى الأول',
                'credit_hours' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'اللغة العربية',
                'code' => 'ARB101',
                'description' => 'مادة اللغة العربية والأدب',
                'grade_level' => 'المستوى الأول',
                'credit_hours' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'اللغة الإنجليزية',
                'code' => 'ENG101',
                'description' => 'مادة اللغة الإنجليزية',
                'grade_level' => 'المستوى الأول',
                'credit_hours' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'التاريخ',
                'code' => 'HIST101',
                'description' => 'مادة التاريخ والجغرافيا',
                'grade_level' => 'المستوى الأول',
                'credit_hours' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'الفيزياء',
                'code' => 'PHY101',
                'description' => 'مادة الفيزياء المتقدمة',
                'grade_level' => 'المستوى الثاني',
                'credit_hours' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'الكيمياء',
                'code' => 'CHEM101',
                'description' => 'مادة الكيمياء المتقدمة',
                'grade_level' => 'المستوى الثاني',
                'credit_hours' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'الأحياء',
                'code' => 'BIO101',
                'description' => 'مادة الأحياء والحياة',
                'grade_level' => 'المستوى الثاني',
                'credit_hours' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'الحاسوب',
                'code' => 'COMP101',
                'description' => 'مادة الحاسوب والبرمجة',
                'grade_level' => 'المستوى الثاني',
                'credit_hours' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'التربية الإسلامية',
                'code' => 'ISL101',
                'description' => 'مادة التربية الإسلامية',
                'grade_level' => 'المستوى الأول',
                'credit_hours' => 2,
                'is_active' => true,
            ],
        ];

        foreach ($subjects as $subject) {
            Subject::create($subject);
        }
    }
}