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
        Schema::table('session_notes', function (Blueprint $table) {
            $table->unsignedBigInteger('track_session_id')->after('id')->nullable();

            // Optional: Add foreign key constraint
            $table->foreign('track_session_id')->references('id')->on('track_sessions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('session_notes', function (Blueprint $table) {
            // Drop the foreign key first, if it exists
            $table->dropForeign(['track_session_id']);
            $table->dropColumn('track_session_id');
        });
    }
};
