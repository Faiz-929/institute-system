<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * تشغيل التعديلات على قاعدة البيانات
     */
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            // ✅ إضافة حقل اسم ولي الأمر الرباعي
            $table->string('parent_name')->nullable()->after('notes')->comment('اسم ولي الامر الرباعي');
            
            // ✅ إضافة رقم الجوال
            $table->string('parent_mobile')->nullable()->comment('رقم جوال ولي الامر');
            
            // ✅ إضافة رقم الواتس
            $table->string('parent_whatsapp')->nullable()->comment('رقم واتس ولي الامر');
            
            // ✅ إضافة رقم البيت
            $table->string('parent_home_phone')->nullable()->comment('رقم البيت لولي الامر');
            
            // ✅ إضافة الوظيفة
            $table->string('parent_job')->nullable()->comment('وظيفة ولي الامر');
        });
    }

    /**
     * التراجع عن التعديلات (لو عملت rollback)
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn([
                'parent_name',
                'parent_mobile',
                'parent_whatsapp',
                'parent_home_phone',
                'parent_job',
            ]);
        });
    }
};
