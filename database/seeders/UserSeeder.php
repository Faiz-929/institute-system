<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // إنشاء مدير النظام
        User::create([
            'name' => 'مدير النظام',
            'email' => 'admin@institute.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // إنشاء معلمين
        $teachers = [
            [
                'name' => 'أحمد محمد',
                'email' => 'ahmed@institute.com',
                'password' => Hash::make('teacher123'),
                'role' => 'teacher',
            ],
            [
                'name' => 'فاطمة أحمد',
                'email' => 'fatima@institute.com',
                'password' => Hash::make('teacher123'),
                'role' => 'teacher',
            ],
            [
                'name' => 'محمد علي',
                'email' => 'mohamed@institute.com',
                'password' => Hash::make('teacher123'),
                'role' => 'teacher',
            ],
            [
                'name' => 'سارة حسن',
                'email' => 'sara@institute.com',
                'password' => Hash::make('teacher123'),
                'role' => 'teacher',
            ],
            [
                'name' => 'عبدالله يوسف',
                'email' => 'abdullah@institute.com',
                'password' => Hash::make('teacher123'),
                'role' => 'teacher',
            ],
        ];

        foreach ($teachers as $teacher) {
            User::create($teacher);
        }

        // إنشاء مستخدمين إضافيين للمختبرات
        User::factory()->count(10)->create([
            'role' => 'teacher',
            'password' => Hash::make('teacher123'),
        ]);
    }
}