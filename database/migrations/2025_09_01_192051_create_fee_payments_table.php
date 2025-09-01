<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('fee_payments', function (Blueprint $table) {
            $table->id();                                                       // مفتاح أساسي
            $table->foreignId('student_fee_id')->constrained('student_fees')->cascadeOnDelete(); // ربط بالرسوم
            $table->decimal('amount', 10, 2);                                   // مبلغ الدفعة
            $table->date('paid_at')->nullable();                                // تاريخ الدفعة
            $table->string('method')->nullable();                               // طريقة الدفع (نقدي/تحويل...)
            $table->string('reference')->nullable();                            // مرجع/إيصال
            $table->foreignId('received_by')->nullable()->constrained('users')->nullOnDelete();  // المستلم (مستخدم النظام)
            $table->text('note')->nullable();                                   // ملاحظة
            $table->timestamps();
            $table->index(['student_fee_id']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('fee_payments');
    }
};
