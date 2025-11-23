@extends('layouts.admin')

@section('title', 'Chi tiết Câu hỏi')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/qa.css') }}">
@endpush

@section('content')
<div class="admin-page">
    <div style="margin-bottom: 20px;">
        <a href="{{ route('admin.questions.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <!-- Question -->
    <div class="admin-card" style="margin-bottom: 30px;">
        <div class="question-detail-header" style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 20px;">
            <div>
                <h1 class="admin-question-title">{{ $question->title }}</h1>
                <div class="question-meta">
                    <span><strong>Khóa học:</strong> {{ $question->course->title }}</span>
                    @if($question->lesson)
                        <span><strong>Bài học:</strong> {{ $question->lesson->title }}</span>
                    @endif
                    <span><strong>Người hỏi:</strong> {{ $question->user->name }}</span>
                    <span><strong>Ngày:</strong> {{ $question->created_at->format('d/m/Y H:i') }}</span>
                    <span><strong>Lượt xem:</strong> {{ $question->views }}</span>
                </div>
            </div>
            
            <div style="display: flex; gap: 8px;">
                @if($question->is_resolved)
                    <span class="badge-resolved" style="padding: 8px 16px;">
                        <i class="fas fa-check"></i> Đã giải quyết
                    </span>
                @endif
                
                @if($question->status === 'pending')
                    <span class="badge-pending" style="padding: 8px 16px;">Chờ trả lời</span>
                @elseif($question->status === 'answered')
                    <span class="badge-answered" style="padding: 8px 16px;">Đã trả lời</span>
                @else
                    <span class="badge badge-secondary" style="padding: 8px 16px;">Đã đóng</span>
                @endif
            </div>
        </div>

        <div class="question-content-box">{{ $question->content }}</div>

        <div class="question-actions">
            <form action="{{ route('admin.questions.destroy', $question) }}" method="POST" style="display: inline;" onsubmit="return confirm('Bạn có chắc muốn xóa câu hỏi này?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-trash"></i> Xóa câu hỏi
                </button>
            </form>
        </div>
    </div>

    <!-- Answers -->
    <div class="admin-card">
        <h2 class="answers-title">
            Câu trả lời ({{ $question->answers->count() }})
        </h2>

        @if($question->answers->count() > 0)
            @foreach($question->answers as $answer)
                <div class="answer-item {{ $answer->is_best_answer ? 'best-answer' : '' }}">
                    <div class="answer-header" style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 12px;">
                        <div>
                            <strong>{{ $answer->user->name }}</strong>
                            @if($answer->user->role === 'instructor')
                                <span class="role-badge role-instructor">Giảng viên</span>
                            @elseif($answer->user->role === 'admin')
                                <span class="role-badge role-admin">Admin</span>
                            @endif
                            @if($answer->is_best_answer)
                                <span class="best-answer-badge">
                                    <i class="fas fa-star"></i> Best Answer
                                </span>
                            @endif
                            <div class="answer-time">
                                {{ $answer->created_at->format('d/m/Y H:i') }}
                            </div>
                        </div>
                        
                        <form action="{{ route('admin.answers.destroy', $answer) }}" method="POST" style="display: inline;" onsubmit="return confirm('Xóa câu trả lời này?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i> Xóa
                            </button>
                        </form>
                    </div>

                    <div class="answer-content">{{ $answer->content }}</div>
                </div>
            @endforeach
        @else
            <div class="empty-answers">
                <i class="fas fa-comments"></i>
                <p>Chưa có câu trả lời nào</p>
            </div>
        @endif
    </div>
</div>
@endsection
