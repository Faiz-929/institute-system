<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('اسم المادة');
            $table->string('code')->unique()->comment('رمز المادة');
            $table->text('description')->nullable()->comment('وصف المادة');
            $table->string('grade_level')->comment('المستوى الدراسي');
            $table->integer('credit_hours')->default(3)->comment('الساعات المعتمدة');
            $table->boolean('is_active')->default(true)->comment('حالة المادة');
            $table->timestamps();
            
            // فهارس للأداء
            $table->index('grade_level');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};
