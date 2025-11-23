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
        Schema::create('answers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('question_id'); // Câu hỏi được trả lời
            $table->unsignedBigInteger('user_id'); // Người trả lời (instructor hoặc admin)
            $table->text('content'); // Nội dung câu trả lời
            $table->boolean('is_best_answer')->default(false); // Câu trả lời tốt nhất (do học sinh chọn)
            $table->timestamps();
            
            // Indexes
            $table->index('question_id', 'idx_answer_question');
            $table->index('user_id', 'idx_answer_user');
            
            // Foreign keys
            $table->foreign('question_id', 'fk_answer_question')
                  ->references('id')
                  ->on('questions')
                  ->onDelete('cascade');
            
            $table->foreign('user_id', 'fk_answer_user')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answers');
    }
};
