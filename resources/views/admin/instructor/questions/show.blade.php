@extends('layouts.admin')

@section('title', $question->title . ' - Hỏi đáp')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/qa.css') }}">
@endpush

@section('content')
<div class="qa-container">
    <nav class="qa-breadcrumb">
        <a href="{{ route('admin.questions.index') }}" class="back-link">
            <i class="fas fa-arrow-left"></i> Quay lại danh sách
        </a>
    </nav>

    @if(session('success'))
        <div class="alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <!-- Question -->
    <div class="question-detail">
        <div class="question-detail-header">
            <h1>{{ $question->title }}</h1>
            
            <div class="question-meta">
                <span class="course-name">{{ $question->course->title }}</span>
                
                @if($question->lesson)
                    <span><i class="fas fa-play-circle"></i> {{ $question->lesson->title }}</span>
                @else
                    <span><i class="fas fa-book"></i> Câu hỏi chung</span>
                @endif
                
                <span><i class="fas fa-user"></i> {{ $question->user->name }}</span>
                <span><i class="fas fa-clock"></i> {{ $question->created_at->diffForHumans() }}</span>
                <span><i class="fas fa-eye"></i> {{ $question->views }} lượt xem</span>
                
                @if($question->is_resolved)
                    <span class="badge-resolved">
                        <i class="fas fa-check"></i> Đã giải quyết
                    </span>
                @endif
            </div>
        </div>

        <div class="question-content">{{ $question->content }}</div>
    </div>

    <!-- Answers -->
    <div class="answers-section">
        <h2 class="answers-title">
            {{ $question->answers->count() }} câu trả lời
        </h2>

        @foreach($question->answers as $answer)
            <div class="answer-item {{ $answer->is_best_answer ? 'best-answer' : '' }}">
                <div class="answer-header">
                    <div class="user-avatar">
                        {{ strtoupper(substr($answer->user->name, 0, 1)) }}
                    </div>
                    <div class="answer-author-info">
                        <div class="author-name">
                            {{ $answer->user->name }}
                            @if($answer->user->role === 'instructor')
                                <span class="role-badge role-instructor">
                                    GIẢNG VIÊN
                                </span>
                            @elseif($answer->user->role === 'admin')
                                <span class="role-badge role-admin">
                                    ADMIN
                                </span>
                            @endif
                            @if($answer->is_best_answer)
                                <span class="best-answer-badge">
                                    <i class="fas fa-star"></i> BEST ANSWER
                                </span>
                            @endif
                        </div>
                        <div class="answer-time">{{ $answer->created_at->diffForHumans() }}</div>
                    </div>

                    @if(Auth::id() === $answer->user_id)
                        <form action="{{ route('instructor.answers.destroy', $answer) }}" method="POST" onsubmit="return confirm('Xóa câu trả lời?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    @endif
                </div>

                <div class="answer-content">{{ $answer->content }}</div>
            </div>
        @endforeach
    </div>

    <!-- Answer Form -->
    <div class="answer-form-container">
        <h3 class="form-title">Trả lời câu hỏi</h3>
        
        <form action="{{ route('admin.questions.answer', $question) }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label for="content" class="form-label">
                    Câu trả lời của bạn <span class="required">*</span>
                </label>
                <textarea name="content" id="content" rows="6" required
                          placeholder="Nhập câu trả lời chi tiết..."
                          class="form-control">{{ old('content') }}</textarea>
                @error('content')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn-submit">
                <i class="fas fa-paper-plane"></i> Gửi câu trả lời
            </button>
        </form>
    </div>
</div>
@endsection
