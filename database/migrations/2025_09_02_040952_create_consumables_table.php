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
        Schema::create('assets', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('serial_number')->nullable();
    $table->date('purchase_date')->nullable();
    $table->enum('status',['available','in_use','maintenance','retired'])->default('available');
    $table->foreignId('workshop_id')->constrained()->cascadeOnDelete();
    $table->timestamps();
});


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consumables');
    }
};
