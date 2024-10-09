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
        Schema::create('track_sessions', function (Blueprint $table) {
            $table->unsignedBigInteger('id', true)->primary();
            $table->string('name');
            $table->unsignedInteger('track_id');
            $table->foreign('track_id')->references('id')->on('tracks')->onDelete('cascade');
            $table->date('session_date')->nullable();
            $table->time('start_time');
            $table->time('end_time');
            $table->text('description')->nullable();
            $table->enum('location', ['online', 'offline']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('track_sessions'); // Drop the dependent table first
        Schema::dropIfExists('sessions');
    }
};
