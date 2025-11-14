<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        $students = [
            [
                'name' => 'عمر أحمد محمد',
                'mobile_phone' => '0501234567',
                'address' => 'شارع الملك فهد، الرياض',
                'status' => 'active',
                'gender' => 'male',
                'level' => 'ثالثة',
                'major' => 'كهرباء عام',
                'notes' => 'طالب مجتهد ومتفاعل',
                'parent_name' => 'أحمد محمد علي',
                'parent_mobile' => '0507654321',
                'parent_job' => 'مهندس',
            ],
            [
                'name' => 'فاطمة عبدالرحمن',
                'mobile_phone' => '0509876543',
                'address' => 'شارع العليا، الرياض',
                'status' => 'active',
                'gender' => 'female',
                'level' => 'ثالثة',
                'major' => 'تبريد وتكييف',
                'notes' => 'ممتازة في الرياضيات',
                'parent_name' => 'عبدالرحمن سالم حسن',
                'parent_mobile' => '0506543210',
            ],
            [
                'name' => 'خالد عبدالله',
                'mobile_phone' => '0504567890',
                'address' => 'حي الملز، الرياض',
                'status' => 'active',
                'gender' => 'male',
                'level' => 'ثانية',
                'major' => 'كهرباء سيارات',
                'notes' => 'مبدع في الأدب',
                'parent_name' => 'عبدالله خالد أحمد',
                'parent_mobile' => '0507890123',
            ],
            [
                'name' => 'نورا محمد',
                'mobile_phone' => '0503216549',
                'address' => 'حي النرجس، الرياض',
                'status' => 'active',
                'gender' => 'female',
                'level' => 'ثالثة',
                'major' => 'ميكانيكا عام',
                'notes' => 'متفوقة في العلوم',
                'parent_name' => 'محمد أحمد عبدالله',
                'parent_mobile' => '0503210987',
            ],
            [
                'name' => 'سعد عبدالعزيز',
                'mobile_phone' => '0507890123',
                'address' => 'حي الياسمين، الرياض',
                'status' => 'active',
                'gender' => 'male',
                'level' => 'ثانية',
                'major' => 'كهرباء عام',
                'notes' => 'محب للحاسوب والبرمجة',
                'parent_name' => 'عبدالعزيز محمد سعد',
                'parent_mobile' => '0508901234',
                'parent_job' => 'مهندس مدني',
            ],
        ];

        foreach ($students as $student) {
            Student::create($student);
        }

        // إنشاء طلاب إضافيين عشوائياً
        Student::factory()->count(25)->create();
    }
}