<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('status')->nullable();       // حالة الطالب (منتظم، منقطع..)
            $table->string('gender')->nullable();       // الجنس (ذكر، أنثى)
            $table->string('photo')->nullable();        // مسار صورة الطالب
            $table->string('address')->nullable();      // عنوان السكن
            $table->string('home_phone')->nullable();   // رقم هاتف البيت
            $table->string('mobile_phone')->nullable(); // رقم جوال الطالب
            $table->string('level')->nullable();        // المستوى الدراسي (أولى، ثانية، ثالثة)
            $table->string('major')->nullable();        // التخصص (كهرباء عام، تبريد وتكييف، كهرباء سيارات)
            $table->text('notes')->nullable();          // ملاحظات إضافية
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
