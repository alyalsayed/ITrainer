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
        Schema::create('tracks', function (Blueprint $table) {
            $table->unsignedInteger('id', true)->primary();
            $table->string('name');
            $table->text('description')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->unsignedBigInteger('instructor_id')->nullable(); // Removed after() method
            $table->unsignedBigInteger('hr_id')->nullable(); // Removed after() method
            $table->timestamps();

            // Foreign keys
            $table->foreign('instructor_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('hr_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracks');
    }
};
