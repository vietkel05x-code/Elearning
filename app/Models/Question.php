<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    protected $fillable = [
        'user_id',
        'course_id',
        'lesson_id',
        'title',
        'content',
        'status',
        'is_resolved',
        'views',
    ];

    protected $casts = [
        'is_resolved' => 'boolean',
        'views' => 'integer',
    ];

    /**
     * Người hỏi (học sinh)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Khóa học
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Bài học (nullable)
     */
    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }

    /**
     * Các câu trả lời
     */
    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class)->orderBy('created_at', 'asc');
    }

    /**
     * Câu trả lời tốt nhất
     */
    public function bestAnswer(): HasMany
    {
        return $this->hasMany(Answer::class)->where('is_best_answer', true);
    }

    /**
     * Increment views
     */
    public function incrementViews(): void
    {
        $this->increment('views');
    }

    /**
     * Mark as resolved
     */
    public function markAsResolved(): void
    {
        $this->update([
            'is_resolved' => true,
            'status' => 'closed'
        ]);
    }

    /**
     * Scope: pending questions
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope: answered questions
     */
    public function scopeAnswered($query)
    {
        return $query->where('status', 'answered');
    }

    /**
     * Scope: by course
     */
    public function scopeByCourse($query, $courseId)
    {
        return $query->where('course_id', $courseId);
    }
}
