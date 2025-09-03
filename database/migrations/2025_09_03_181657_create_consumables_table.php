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
        Schema::create('consumables', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->decimal('quantity',10,2)->default(0);
    $table->string('unit')->default('pcs'); // قطعة، كغ، لتر، إلخ
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
