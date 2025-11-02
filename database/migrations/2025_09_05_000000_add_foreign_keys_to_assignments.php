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
        // إضافة Foreign Keys بعد إنشاء جميع الجداول
        Schema::table('assignments', function (Blueprint $table) {
            $table->foreign('asset_id')
                  ->references('id')
                  ->on('assets')
                  ->nullOnDelete();
                  
            $table->foreign('consumable_id')
                  ->references('id')
                  ->on('consumables')
                  ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assignments', function (Blueprint $table) {
            $table->dropForeign(['asset_id']);
            $table->dropForeign(['consumable_id']);
        });
    }
};
