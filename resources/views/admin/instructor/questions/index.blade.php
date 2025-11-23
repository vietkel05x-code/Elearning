@extends('layouts.admin')

@section('title', 'Quản lý Hỏi Đáp - Giảng viên')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/qa.css') }}">
@endpush

@section('content')
<div class="qa-container">
    <!-- Header -->
    <div class="qa-header">
        <h1>Quản lý Hỏi Đáp</h1>
        <p>Trả lời câu hỏi từ học viên của bạn</p>
    </div>

    <!-- Filters -->
    <div class="filter-section">
        <form method="GET" action="{{ route('admin.questions.index') }}">
            <div class="filter-group">
                <!-- Status Filter -->
                <div>
                    <label class="form-label">Trạng thái</label>
                    <select name="status" class="form-control">
                        <option value="">Tất cả</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Chờ trả lời</option>
                        <option value="answered" {{ request('status') === 'answered' ? 'selected' : '' }}>Đã trả lời</option>
                        <option value="closed" {{ request('status') === 'closed' ? 'selected' : '' }}>Đã đóng</option>
                    </select>
                </div>

                <!-- Course Filter -->
                <div>
                    <label class="form-label">Khóa học</label>
                    <select name="course_id" class="form-control">
                        <option value="">Tất cả khóa học</option>
                        @foreach($courses as $courseItem)
                            <option value="{{ $courseItem->id }}" {{ request('course_id') == $courseItem->id ? 'selected' : '' }}>
                                {{ $courseItem->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Search -->
                <div>
                    <label class="form-label">Tìm kiếm</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Tiêu đề câu hỏi..." class="form-control">
                </div>

                <!-- Submit -->
                <div style="display: flex; align-items: flex-end;">
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-filter"></i> Lọc
                    </button>
                </div>
            </div>
        </form>
    </div>

    @if(session('success'))
        <div class="alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <!-- Questions List -->
    @if($questions->count() > 0)
        <div class="question-list">
            @foreach($questions as $question)
                <div class="question-item" style="{{ $loop->last ? 'border-bottom: none;' : '' }}">
                    <a href="{{ route('admin.questions.show', $question) }}" style="text-decoration: none; color: inherit; display: block;">
                        <div style="display: flex; gap: 16px;">
                            <!-- Stats -->
                            <div class="question-stats">
                                <div class="stat-box {{ $question->answers_count > 0 ? 'answered' : '' }}">
                                    <div class="stat-number">
                                        {{ $question->answers_count }}
                                    </div>
                                    <div class="stat-label">trả lời</div>
                                </div>
                            </div>

                            <!-- Content -->
                            <div style="flex: 1;">
                                <h3 class="question-title">
                                    {{ $question->title }}
                                    @if($question->is_resolved)
                                        <span class="badge-resolved">
                                            <i class="fas fa-check"></i> Resolved
                                        </span>
                                    @endif
                                </h3>
                                
                                <p class="question-excerpt">
                                    {{ Str::limit(strip_tags($question->content), 150) }}
                                </p>

                                <div class="question-meta">
                                    <span class="course-name">{{ $question->course->title }}</span>
                                    
                                    @if($question->lesson)
                                        <span><i class="fas fa-play-circle"></i> {{ $question->lesson->title }}</span>
                                    @endif
                                    
                                    <span><i class="fas fa-user"></i> {{ $question->user->name }}</span>
                                    <span><i class="fas fa-clock"></i> {{ $question->created_at->diffForHumans() }}</span>
                                    
                                    @if($question->status === 'pending')
                                        <span class="badge-pending">
                                            <i class="fas fa-hourglass-half"></i> Chờ trả lời
                                        </span>
                                    @elseif($question->status === 'answered')
                                        <span class="badge-answered">
                                            <i class="fas fa-check"></i> Đã trả lời
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div style="margin-top: 20px;">
            {{ $questions->links() }}
        </div>
    @else
        <div class="empty-state">
            <i class="fas fa-inbox"></i>
            <h3>Không có câu hỏi nào</h3>
            <p>Chưa có học viên nào đặt câu hỏi.</p>
        </div>
    @endif
</div>
@endsection
