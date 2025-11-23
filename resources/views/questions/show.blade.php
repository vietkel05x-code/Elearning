@extends('layouts.app')

@section('title', $question->title . ' - Hỏi đáp')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/qa.css') }}">
@endpush

@section('content')
<div class="qa-container qa-container-wide">
    <!-- Breadcrumb -->
    <nav class="qa-breadcrumb">
        <a href="{{ route('home') }}">Trang chủ</a>
        <span>/</span>
        <a href="{{ route('student.learn', $course) }}">{{ $course->title }}</a>
        <span>/</span>
        <a href="{{ route('questions.index', $course) }}">Hỏi đáp</a>
        <span>/</span>
        <span>{{ Str::limit($question->title, 50) }}</span>
    </nav>

    @if(session('success'))
        <div class="alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <!-- Question -->
    <div class="question-detail-card">
        <!-- Question Header -->
        <div class="question-detail-header">
            <h1>{{ $question->title }}</h1>
            
            <div class="question-meta">
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
                @elseif($question->status === 'pending')
                    <span class="badge-pending">
                        <i class="fas fa-hourglass-half"></i> Chờ trả lời
                    </span>
                @elseif($question->status === 'answered')
                    <span class="badge-answered">
                        <i class="fas fa-comment-dots"></i> Đã có trả lời
                    </span>
                @endif
            </div>
        </div>

        <!-- Question Content -->
        <div class="question-detail-content">{{ $question->content }}</div>

        <!-- Question Actions -->
        @if(Auth::id() === $question->user_id)
            <div class="question-actions">
                @if(!$question->is_resolved)
                    <form action="{{ route('questions.resolve', [$course, $question]) }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn-resolve">
                            <i class="fas fa-check"></i> Đánh dấu đã giải quyết
                        </button>
                    </form>
                @endif
                
                <form action="{{ route('questions.destroy', [$course, $question]) }}" method="POST" style="display: inline;" onsubmit="return confirm('Bạn có chắc muốn xóa câu hỏi này?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-delete">
                        <i class="fas fa-trash"></i> Xóa câu hỏi
                    </button>
                </form>
            </div>
        @endif
    </div>

    <!-- Answers Section -->
    <div class="answers-section">
        <h2 class="answers-title">
            {{ $question->answers->count() }} câu trả lời
        </h2>

        @if($question->answers->count() > 0)
            @foreach($question->answers as $answer)
                <div class="answer-item {{ $answer->is_best_answer ? 'answer-best' : '' }}">
                    <!-- Answer Header -->
                    <div class="answer-header">
                        <div class="answer-avatar">
                            {{ strtoupper(substr($answer->user->name, 0, 1)) }}
                        </div>
                        <div class="answer-author-info">
                            <div class="answer-author-name">
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
                                        <i class="fas fa-check"></i> CÂU TRẢ LỜI TỐT NHẤT
                                    </span>
                                @endif
                            </div>
                            <div class="answer-time">
                                {{ $answer->created_at->diffForHumans() }}
                            </div>
                        </div>
                    </div>

                    <!-- Answer Content -->
                    <div class="answer-content">{{ $answer->content }}</div>

                    <!-- Answer Actions -->
                    <div class="answer-actions">
                        @if(Auth::id() === $question->user_id && !$answer->is_best_answer && !$question->is_resolved)
                            <form action="{{ route('questions.select-best', [$course, $question, $answer]) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn-select-best">
                                    <i class="fas fa-check-circle"></i> Chọn làm câu trả lời tốt nhất
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        @else
            <div class="empty-state">
                <i class="fas fa-comments empty-state-icon"></i>
                <p>Chưa có câu trả lời nào. Hãy chờ giảng viên trả lời!</p>
            </div>
        @endif
    </div>

    <!-- Back Button -->
    <a href="{{ route('questions.index', $course) }}" class="back-link">
        <i class="fas fa-arrow-left"></i> Quay lại danh sách câu hỏi
    </a>
</div>
@endsection
