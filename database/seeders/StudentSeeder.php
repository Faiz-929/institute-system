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
                'status' => 'نشط',
                'gender' => 'ذكر',
                'address' => 'شارع الملك فهد، الرياض',
                'home_phone' => '01123456789',
                'mobile_phone' => '0501234567',
                'level' => 'المستوى الأول',
                'major' => 'علمي',
                'notes' => 'طالب مجتهد ومتفاعل',
                'parent_name' => 'أحمد محمد علي',
                'parent_mobile' => '0507654321',
                'parent_whatsapp' => '0507654321',
                'parent_home_phone' => '01123456789',
                'parent_job' => 'مهندس',
            ],
            [
                'name' => 'فاطمة عبدالرحمن',
                'status' => 'نشط',
                'gender' => 'أنثى',
                'address' => 'شارع العليا، الرياض',
                'home_phone' => '0119876543',
                'mobile_phone' => '0509876543',
                'level' => 'المستوى الأول',
                'major' => 'علمي',
                'notes' => 'ممتازة في الرياضيات',
                'parent_name' => 'عبدالرحمن سالم حسن',
                'parent_mobile' => '0506543210',
                'parent_whatsapp' => '0506543210',
                'parent_home_phone' => '0119876543',
                'parent_job' => 'طبيب',
            ],
            [
                'name' => 'خالد عبدالله',
                'status' => 'نشط',
                'gender' => 'ذكر',
                'address' => 'حي الملز، الرياض',
                'home_phone' => '0114567890',
                'mobile_phone' => '0504567890',
                'level' => 'المستوى الثاني',
                'major' => 'أدبي',
                'notes' => 'مبدع في الأدب',
                'parent_name' => ' عبدالله خالد أحمد',
                'parent_mobile' => '0507890123',
                'parent_whatsapp' => '0507890123',
                'parent_home_phone' => '0114567890',
                'parent_job' => 'محاسب',
            ],
            [
                'name' => 'نورا محمد',
                'status' => 'نشط',
                'gender' => 'أنثى',
                'address' => 'حي النرجس، الرياض',
                'home_phone' => '0113216549',
                'mobile_phone' => '0503216549',
                'level' => 'المستوى الأول',
                'major' => 'علمي',
                'notes' => 'متفوقة في العلوم',
                'parent_name' => 'محمد أحمد عبدالله',
                'parent_mobile' => '0503210987',
                'parent_whatsapp' => '0503210987',
                'parent_home_phone' => '0113216549',
                'parent_job' => 'معلم',
            ],
            [
                'name' => 'سعد عبدالعزيز',
                'status' => 'نشط',
                'gender' => 'ذكر',
                'address' => 'حي الياسمين، الرياض',
                'home_phone' => '0117890123',
                'mobile_phone' => '0507890123',
                'level' => 'المستوى الثاني',
                'major' => 'علمي',
                'notes' => 'محب للحاسوب والبرمجة',
                'parent_name' => 'عبدالaziz محمد سعد',
                'parent_mobile' => '0508901234',
                'parent_whatsapp' => '0508901234',
                'parent_home_phone' => '0117890123',
                'parent_job' => 'مهندس حاسوب',
            ],
        ];

        foreach ($students as $student) {
            Student::create($student);
        }

        // إنشاء طلاب إضافيين عشوائياً
        Student::factory()->count(25)->create();
    }
}