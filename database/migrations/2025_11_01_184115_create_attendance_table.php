<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendance', function (Blueprint $table) {
            $table->id();
            
            // العلاقات الأساسية
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->foreignId('teacher_id')->constrained('teachers')->cascadeOnDelete();
            
            // معلومات الحصة
            $table->string('subject_name')->comment('اسم المادة/الحصة');
            $table->string('class_name')->comment('اسم الفصل/الورشة');
            $table->string('session_date')->comment('تاريخ الحصة');
            $table->string('session_time')->comment('وقت الحصة');
            
            // حالة الحضور والغياب
            $table->enum('status', ['حاضر', 'غائب', 'متأخر', 'مُعفى'])->default('حاضر');
            $table->string('absence_reason')->nullable()->comment('سبب الغياب');
            $table->string('late_minutes')->nullable()->comment('دقائق التأخير');
            
            // معلومات إضافية
            $table->text('notes')->nullable()->comment('ملاحظات');
            $table->enum('recorded_by', ['teacher', 'admin'])->default('teacher');
            $table->timestamps();
            
            // فهارس للأداء
            $table->index(['student_id', 'session_date']);
            $table->index(['teacher_id', 'session_date']);
            $table->index(['status', 'session_date']);
            $table->index('session_date');
            
            // قيود للبيانات
            $table->unique(['student_id', 'subject_name', 'session_date', 'session_time'], 'unique_attendance_per_session');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendance');
    }
};
