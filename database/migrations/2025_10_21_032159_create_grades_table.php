<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('grades', function (Blueprint $table) {
            $table->id();

            // العلاقات
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->foreignId('subject_id')->constrained()->cascadeOnDelete();
            $table->foreignId('teacher_id')->constrained()->cascadeOnDelete();

            // النصف الأول
            $table->decimal('homework1', 5, 2)->default(0)->comment('الواجبات - الشهر الأول');
            $table->decimal('participation1', 5, 2)->default(0)->comment('المشاركة - الشهر الأول');
            $table->decimal('written_exam1', 5, 2)->default(0)->comment('الاختبار التحريري - الشهر الأول');

            $table->decimal('homework2', 5, 2)->default(0)->comment('الواجبات - الشهر الثاني');
            $table->decimal('participation2', 5, 2)->default(0)->comment('المشاركة - الشهر الثاني');
            $table->decimal('written_exam2', 5, 2)->default(0)->comment('الاختبار التحريري - الشهر الثاني');

            $table->decimal('midterm1', 5, 2)->default(0)->comment('الاختبار النصفي - النصف الأول');

            // النصف الثاني
            $table->decimal('homework3', 5, 2)->default(0)->comment('الواجبات - الشهر الثالث');
            $table->decimal('participation3', 5, 2)->default(0)->comment('المشاركة - الشهر الثالث');
            $table->decimal('written_exam3', 5, 2)->default(0)->comment('الاختبار التحريري - الشهر الثالث');

            $table->decimal('homework4', 5, 2)->default(0)->comment('الواجبات - الشهر الرابع');
            $table->decimal('participation4', 5, 2)->default(0)->comment('المشاركة - الشهر الرابع');
            $table->decimal('written_exam4', 5, 2)->default(0)->comment('الاختبار التحريري - الشهر الرابع');

            $table->decimal('final_exam', 5, 2)->default(0)->comment('الاختبار النهائي');

            $table->decimal('total', 7, 2)->default(0)->comment('المجموع الكلي');

            $table->string('semester')->comment('الفصل الدراسي');
            $table->string('year')->comment('السنة الدراسية');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};
