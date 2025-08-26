<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // إنشاء جدول الحضور "attendances"
        Schema::create('attendances', function (Blueprint $table) {
            $table->id(); // معرف حضور فريد
            $table->foreignId('session_id')->constrained()->onDelete('cascade'); 
            // ربط الحضور بالحصة، حذف عند حذف الحصة
            $table->foreignId('student_id')->constrained()->onDelete('cascade'); 
            // ربط الحضور بالطالب، حذف عند حذف الطالب
            $table->enum('status', ['حاضر', 'غائب', 'متأخر'])->default('غائب'); 
            // حالة الحضور، الافتراضي غائب
            $table->text('notes')->nullable(); // ملاحظات إضافية (اختياري)
            $table->timestamps(); // created_at و updated_at

            $table->unique(['session_id', 'student_id']); 
            // منع تسجيل حضور الطالب أكثر من مرة لنفس الحصة
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attendances');
    }
}
