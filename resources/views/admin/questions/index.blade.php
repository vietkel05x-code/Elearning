@extends('layouts.admin')

@section('title', 'Quản lý Hỏi Đáp')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/qa.css') }}">
@endpush

@section('content')
<div class="admin-page">
    <div class="admin-header">
        <h1>Quản lý Hỏi Đáp (Q&A)</h1>
        <p>Tổng quan và quản lý câu hỏi từ học viên</p>
    </div>

    <!-- Statistics -->
    <div class="stats-grid">
        <div class="stat-card stat-total">
            <div class="stat-value">{{ $stats['total'] }}</div>
            <div class="stat-label">Tổng câu hỏi</div>
        </div>
        <div class="stat-card stat-pending">
            <div class="stat-value">{{ $stats['pending'] }}</div>
            <div class="stat-label">Chờ trả lời</div>
        </div>
        <div class="stat-card stat-answered">
            <div class="stat-value">{{ $stats['answered'] }}</div>
            <div class="stat-label">Đã trả lời</div>
        </div>
        <div class="stat-card stat-closed">
            <div class="stat-value">{{ $stats['closed'] }}</div>
            <div class="stat-label">Đã đóng</div>
        </div>
    </div>

    <!-- Filters -->
    <div class="admin-card" style="margin-bottom: 20px;">
        <form method="GET" action="{{ route('admin.questions.index') }}">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">
                <div>
                    <label class="form-label">Trạng thái</label>
                    <select name="status" class="form-control">
                        <option value="">Tất cả</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Chờ trả lời</option>
                        <option value="answered" {{ request('status') === 'answered' ? 'selected' : '' }}>Đã trả lời</option>
                        <option value="closed" {{ request('status') === 'closed' ? 'selected' : '' }}>Đã đóng</option>
                    </select>
                </div>

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

                <div>
                    <label class="form-label">Tìm kiếm</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Tiêu đề câu hỏi..." class="form-control">
                </div>

                <div style="display: flex; align-items: flex-end;">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter"></i> Lọc
                    </button>
                </div>
            </div>
        </form>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <!-- Questions Table -->
    @if($questions->count() > 0)
        <div class="admin-card">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Câu hỏi</th>
                        <th>Khóa học</th>
                        <th>Người hỏi</th>
                        <th>Trạng thái</th>
                        <th>Trả lời</th>
                        <th>Ngày tạo</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($questions as $question)
                        <tr>
                            <td>{{ $question->id }}</td>
                            <td>
                                <a href="{{ route('admin.questions.show', $question) }}" class="question-link">
                                    {{ Str::limit($question->title, 50) }}
                                </a>
                                @if($question->is_resolved)
                                    <span class="badge badge-success" style="margin-left: 6px;">Resolved</span>
                                @endif
                            </td>
                            <td>{{ $question->course->title }}</td>
                            <td>{{ $question->user->name }}</td>
                            <td>
                                @if($question->status === 'pending')
                                    <span class="badge badge-warning">Chờ trả lời</span>
                                @elseif($question->status === 'answered')
                                    <span class="badge badge-success">Đã trả lời</span>
                                @else
                                    <span class="badge badge-secondary">Đã đóng</span>
                                @endif
                            </td>
                            <td>{{ $question->answers_count }}</td>
                            <td>{{ $question->created_at->format('d/m/Y') }}</td>
                            <td>
                                <div style="display: flex; gap: 8px;">
                                    <a href="{{ route('admin.questions.show', $question) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <form action="{{ route('admin.questions.destroy', $question) }}" method="POST" style="display: inline;" onsubmit="return confirm('Xóa câu hỏi này?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div style="margin-top: 20px;">
                {{ $questions->links() }}
            </div>
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
