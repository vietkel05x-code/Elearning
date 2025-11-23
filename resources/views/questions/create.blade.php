@extends('layouts.app')

@section('title', 'Đặt câu hỏi - ' . $course->title)

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/qa.css') }}">
@endpush

@section('content')
<div class="qa-container">
    <!-- Breadcrumb -->
    <nav class="qa-breadcrumb">
        <a href="{{ route('home') }}">Trang chủ</a>
        <span>/</span>
        <a href="{{ route('student.learn', $course) }}">{{ $course->title }}</a>
        <span>/</span>
        <a href="{{ route('questions.index', $course) }}">Hỏi đáp</a>
        <span>/</span>
        <span>Đặt câu hỏi</span>
    </nav>

    <!-- Header -->
    <div class="qa-header">
        <h1>Đặt câu hỏi mới</h1>
        <p>Đặt câu hỏi về khóa học: <strong>{{ $course->title }}</strong></p>
    </div>

    <!-- Form -->
    <div class="question-form-container">
        <form action="{{ route('questions.store', $course) }}" method="POST">
            @csrf
            
            <!-- Lesson Selection -->
            <div class="form-group">
                <label for="lesson_id" class="form-label">
                    Bài học liên quan (tùy chọn)
                </label>
                <select name="lesson_id" id="lesson_id" class="form-control">
                    <option value="">-- Câu hỏi chung về khóa học --</option>
                    @foreach($lessons as $lessonItem)
                        <option value="{{ $lessonItem->id }}" {{ (old('lesson_id') == $lessonItem->id || (isset($lesson) && $lesson->id == $lessonItem->id)) ? 'selected' : '' }}>
                            {{ $lessonItem->title }}
                        </option>
                    @endforeach
                </select>
                @error('lesson_id')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <!-- Title -->
            <div class="form-group">
                <label for="title" class="form-label">
                    Tiêu đề câu hỏi <span class="required">*</span>
                </label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" 
                       placeholder="Ví dụ: Làm thế nào để..."
                       required
                       class="form-control">
                @error('title')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <!-- Content -->
            <div class="form-group">
                <label for="content" class="form-label">
                    Nội dung câu hỏi <span class="required">*</span>
                </label>
                <textarea name="content" id="content" rows="8" required
                          placeholder="Mô tả chi tiết câu hỏi của bạn..."
                          class="form-control form-textarea">{{ old('content') }}</textarea>
                @error('content')
                    <span class="form-error">{{ $message }}</span>
                @enderror
                <small class="form-hint">
                    <i class="fas fa-info-circle"></i> Hãy mô tả chi tiết để giảng viên có thể trả lời tốt hơn.
                </small>
            </div>

            <!-- Tips -->
            <div class="tips-box">
                <strong class="tips-title">
                    <i class="fas fa-lightbulb"></i> Mẹo đặt câu hỏi hiệu quả:
                </strong>
                <ul>
                    <li>Sử dụng tiêu đề rõ ràng, ngắn gọn</li>
                    <li>Mô tả chi tiết vấn đề bạn gặp phải</li>
                    <li>Đính kèm ảnh chụp màn hình nếu cần</li>
                    <li>Tìm kiếm câu hỏi tương tự trước khi đặt câu hỏi mới</li>
                </ul>
            </div>

            <!-- Buttons -->
            <div class="form-actions">
                <button type="submit" class="btn-submit">
                    <i class="fas fa-paper-plane"></i> Gửi câu hỏi
                </button>
                <a href="{{ route('questions.index', $course) }}" class="btn-cancel">
                    Hủy
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
