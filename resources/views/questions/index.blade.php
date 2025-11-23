@extends('layouts.app')

@section('title', 'Hỏi đáp - ' . $course->title)

@push('styles')
<link rel="stylesheet" href="{{ asset('css/qa.css') }}">
@endpush

@section('content')
<div class="qa-container">
    <!-- Breadcrumb -->
    <nav class="qa-breadcrumb">
        <a href="{{ route('home') }}">Trang chủ</a>
        <span class="qa-breadcrumb-separator">/</span>
        <a href="{{ route('student.courses') }}">Khóa học của tôi</a>
        <span class="qa-breadcrumb-separator">/</span>
        <a href="{{ route('student.learn', $course) }}">{{ $course->title }}</a>
        <span class="qa-breadcrumb-separator">/</span>
        <span class="qa-breadcrumb-current">Hỏi đáp</span>
    </nav>

    <!-- Header -->
    <div class="qa-header">
        <div class="qa-header-content">
            <h1>Hỏi đáp</h1>
            <p>{{ $course->title }}</p>
        </div>
        <a href="{{ route('questions.create', $course) }}" class="btn-ask-question">
            <i class="fas fa-plus"></i> Đặt câu hỏi
        </a>
    </div>

    @if(session('success'))
        <div class="alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <!-- Questions List -->
    @if($questions->count() > 0)
        <div class="questions-list">
            @foreach($questions as $question)
                <div class="question-item">
                    <a href="{{ route('questions.show', [$course, $question]) }}" class="question-item-link">
                        <div class="question-item-content">
                            <!-- Stats -->
                            <div class="question-stats">
                                <div class="question-stat">
                                    <div class="question-stat-number">{{ $question->answers_count }}</div>
                                    <div class="question-stat-label">câu trả lời</div>
                                </div>
                                <div class="question-stat question-stat-views">
                                    <div class="question-stat-number">{{ $question->views }}</div>
                                    <div class="question-stat-label">lượt xem</div>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="question-body">
                                <h3 class="question-title">
                                    {{ $question->title }}
                                    @if($question->is_resolved)
                                        <span class="badge-resolved">
                                            <i class="fas fa-check"></i> Đã giải quyết
                                        </span>
                                    @endif
                                </h3>
                                
                                <p class="question-excerpt">
                                    {{ Str::limit(strip_tags($question->content), 200) }}
                                </p>

                                <div class="question-meta">
                                    @if($question->lesson)
                                        <span><i class="fas fa-play-circle"></i> {{ $question->lesson->title }}</span>
                                    @else
                                        <span><i class="fas fa-book"></i> Câu hỏi chung</span>
                                    @endif
                                    
                                    <span><i class="fas fa-user"></i> {{ $question->user->name }}</span>
                                    <span><i class="fas fa-clock"></i> {{ $question->created_at->diffForHumans() }}</span>
                                    
                                    @if($question->status === 'pending')
                                        <span class="meta-status-pending"><i class="fas fa-hourglass-half"></i> Chờ trả lời</span>
                                    @elseif($question->status === 'answered')
                                        <span class="meta-status-answered"><i class="fas fa-comment-dots"></i> Đã có trả lời</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div style="margin-top: 30px;">
            {{ $questions->links() }}
        </div>
    @else
        <div class="empty-state">
            <i class="fas fa-comments empty-state-icon"></i>
            <h3>Chưa có câu hỏi nào</h3>
            <p>Hãy là người đầu tiên đặt câu hỏi!</p>
            <a href="{{ route('questions.create', $course) }}" class="btn-ask-question">
                <i class="fas fa-plus"></i> Đặt câu hỏi đầu tiên
            </a>
        </div>
    @endif

    <!-- Back Button -->
    <a href="{{ route('student.learn', $course) }}" class="back-link">
        <i class="fas fa-arrow-left"></i> Quay lại khóa học
    </a>
</div>
@endsection
