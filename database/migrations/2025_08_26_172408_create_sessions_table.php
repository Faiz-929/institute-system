<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // إنشاء جدول الحصص "sessions"
        Schema::create('sessions', function (Blueprint $table) {
            $table->id(); // عمود معرف الحصة
            $table->foreignId('teacher_id')->constrained()->onDelete('cascade'); 
            // ربط الحصة بمعلم موجود، حذف الحصة عند حذف المعلم
            $table->date('date'); // تاريخ الحصة
            $table->time('start_time'); // وقت بداية الحصة
            $table->time('end_time')->nullable(); // وقت نهاية الحصة، يمكن أن يكون فارغاً
            $table->string('subject'); // اسم المادة أو موضوع الحصة
            $table->timestamps(); // أعمدة created_at و updated_at تلقائياً
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // حذف جدول الحصص عند التراجع عن الترحيل
        Schema::dropIfExists('sessions');
    }
}
