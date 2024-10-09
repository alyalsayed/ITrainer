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
        Schema::table('tracks', function (Blueprint $table) {
            // Check if 'instructor_id' does not exist before adding it
            if (!Schema::hasColumn('tracks', 'instructor_id')) {
                $table->unsignedBigInteger('instructor_id')->nullable()->after('end_date');
            }

            // Check if 'hr_id' does not exist before adding it
            if (!Schema::hasColumn('tracks', 'hr_id')) {
                $table->unsignedBigInteger('hr_id')->nullable()->after('instructor_id');
            }

            // Foreign keys
            // Adding foreign keys only if they are not already defined
            if (!Schema::hasColumn('tracks', 'instructor_id')) {
                $table->foreign('instructor_id')->references('id')->on('users')->onDelete('set null');
            }
            if (!Schema::hasColumn('tracks', 'hr_id')) {
                $table->foreign('hr_id')->references('id')->on('users')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tracks', function (Blueprint $table) {
            // Drop foreign key constraints
            if (Schema::hasColumn('tracks', 'instructor_id')) {
                $table->dropForeign(['instructor_id']);
            }
            if (Schema::hasColumn('tracks', 'hr_id')) {
                $table->dropForeign(['hr_id']);
            }

            // Drop the columns if they exist
            if (Schema::hasColumn('tracks', 'instructor_id')) {
                $table->dropColumn('instructor_id');
            }
            if (Schema::hasColumn('tracks', 'hr_id')) {
                $table->dropColumn('hr_id');
            }
        });
    }
};
