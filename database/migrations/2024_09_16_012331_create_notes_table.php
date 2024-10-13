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
        Schema::create('session_notes', function (Blueprint $table) {
            $table->unsignedBigInteger('id', true)->primary();
            $table->unsignedBigInteger('session_id');
            $table->string('title')->nullable();
            $table->foreign('session_id')->references('id')->on('track_sessions')->onDelete('cascade');
            $table->enum('type', ['screenshot', 'code', 'text']);
            $table->text('content');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
};
