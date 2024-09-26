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
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('track_id');
            $table->foreign('track_id')->references('id')->on('tracks');
            $table->string('title');
            $table->string('description');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->enum('type', [0, 1, 2])->default(0);
            $table->timestamps();
        });
        Schema::create('quiz_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id')->constrained('quizzes');
            $table->string('title');
            $table->enum('type', [0, 1])->default(0);
            $table->enum('required', [0, 1])->default(1);
            $table->decimal('grade', 20, 2)->default(1);
            $table->timestamps();
        });
        Schema::create('question_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained('quiz_questions');
            $table->text('text');
            $table->enum('correct', [0, 1])->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quizzes');
        Schema::dropIfExists('quiz_questions');
        Schema::dropIfExists('question_answers');
    }
};
