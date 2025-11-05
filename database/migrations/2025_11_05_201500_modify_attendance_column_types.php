<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * NOTE: Changing column types with Schema::table(...->change()) requires
 * the doctrine/dbal package. Run:
 *
 *    composer require doctrine/dbal
 *
 * before running this migration in environments that don't already have it.
 */
return new class extends Migration
{
    public function up(): void
    {
        // Convert textual columns to proper date/time/integer types.
        Schema::table('attendance', function (Blueprint $table) {
            // These change() calls require doctrine/dbal.
            if (Schema::hasColumn('attendance', 'session_date')) {
                $table->date('session_date')->change();
            }

            if (Schema::hasColumn('attendance', 'session_time')) {
                $table->time('session_time')->change();
            }

            if (Schema::hasColumn('attendance', 'late_minutes')) {
                $table->integer('late_minutes')->nullable()->change();
            }
        });
    }

    public function down(): void
    {
        // Revert columns back to string types (original schema)
        Schema::table('attendance', function (Blueprint $table) {
            if (Schema::hasColumn('attendance', 'session_date')) {
                $table->string('session_date')->change();
            }

            if (Schema::hasColumn('attendance', 'session_time')) {
                $table->string('session_time')->change();
            }

            if (Schema::hasColumn('attendance', 'late_minutes')) {
                $table->string('late_minutes')->nullable()->change();
            }
        });
    }
};
