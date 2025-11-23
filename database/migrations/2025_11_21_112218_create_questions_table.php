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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Học sinh hỏi
            $table->unsignedBigInteger('course_id'); // Khóa học
            $table->unsignedBigInteger('lesson_id')->nullable(); // Bài học (nullable nếu hỏi chung về khóa học)
            $table->string('title'); // Tiêu đề câu hỏi
            $table->text('content'); // Nội dung câu hỏi
            $table->enum('status', ['pending', 'answered', 'closed'])->default('pending');
            $table->boolean('is_resolved')->default(false); // Học sinh đánh dấu đã giải quyết
            $table->integer('views')->default(0); // Số lượt xem
            $table->timestamps();
            
            // Indexes
            $table->index('user_id', 'idx_question_user');
            $table->index('course_id', 'idx_question_course');
            $table->index('lesson_id', 'idx_question_lesson');
            $table->index('status', 'idx_question_status');
            
            // Foreign keys
            $table->foreign('user_id', 'fk_question_user')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
            
            $table->foreign('course_id', 'fk_question_course')
                  ->references('id')
                  ->on('courses')
                  ->onDelete('cascade');
            
            $table->foreign('lesson_id', 'fk_question_lesson')
                  ->references('id')
                  ->on('lessons')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
