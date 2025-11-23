<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Answer extends Model
{
    protected $fillable = [
        'question_id',
        'user_id',
        'content',
        'is_best_answer',
    ];

    protected $casts = [
        'is_best_answer' => 'boolean',
    ];

    /**
     * Câu hỏi được trả lời
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * Người trả lời (instructor hoặc admin)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Mark as best answer
     */
    public function markAsBest(): void
    {
        // Bỏ đánh dấu tất cả các câu trả lời khác
        Answer::where('question_id', $this->question_id)
            ->update(['is_best_answer' => false]);
        
        // Đánh dấu câu trả lời này là tốt nhất
        $this->update(['is_best_answer' => true]);
        
        // Cập nhật status của question
        $this->question->update(['status' => 'answered']);
    }
}
