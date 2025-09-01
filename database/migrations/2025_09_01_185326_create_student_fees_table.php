<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('student_fees', function (Blueprint $table) {
            $table->id();                                                // مفتاح أساسي
            $table->foreignId('student_id')->constrained()->cascadeOnDelete(); // ربط بالطلاب
            $table->string('title')->nullable();                         // اسم الرسوم/الفصل/البند (اختياري)
            $table->decimal('amount_due', 10, 2);                        // إجمالي المستحق
            $table->date('due_date')->nullable();                        // تاريخ الاستحقاق
            $table->enum('status', ['pending','partial','paid'])->default('pending'); // حالة السداد
            $table->text('notes')->nullable();                           // ملاحظات
            $table->timestamps();
            $table->index(['student_id', 'status']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('student_fees');
    }
};
