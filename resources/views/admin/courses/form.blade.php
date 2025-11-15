@extends('layouts.admin')

@section('title', $course->exists ? 'Sửa khóa học' : 'Tạo khóa học')
@section('page-title', $course->exists ? 'Sửa khóa học' : 'Tạo khóa học')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/admin.css') }}">
@endpush

@section('content')
<div class="admin-form-page">
  <h2 class="admin-form-page__title">{{ $course->exists ? 'Sửa khóa học' : 'Tạo khóa học' }}</h2>

  @if(session('ok') || session('success'))
    <div class="alert alert--success">{{ session('ok') ?? session('success') }}</div>
  @endif

  @if($errors->any())
    <div class="alert alert--error">
      @foreach($errors->all() as $e) 
        <div>{{ $e }}</div>
      @endforeach
    </div>
  @endif

  <div class="admin-form-grid">
    <!-- Main Form -->
    <div>
      <form method="POST" action="{{ $course->exists ? route('admin.courses.update',$course) : route('admin.courses.store') }}" class="admin-form">
        @csrf
        @if($course->exists) @method('PUT') @endif

        <div class="admin-form__field">
          <label class="admin-form__label">Tiêu đề *</label>
          <input name="title" value="{{ old('title',$course->title) }}" class="admin-form__input" required>
        </div>

        <div class="admin-form__field">
          <label class="admin-form__label">Slug *</label>
          <input name="slug" value="{{ old('slug',$course->slug) }}" class="admin-form__input" required>
        </div>

        <div class="admin-form__field">
          <div class="admin-form__grid admin-form__grid--2">
            <div>
              <label class="admin-form__label">Giá (₫)</label>
              <input type="number" name="price" value="{{ old('price',$course->price) }}" class="admin-form__input" min="0" step="1000">
            </div>
            <div>
              <label class="admin-form__label">Giá so sánh (₫)</label>
              <input type="number" name="compare_at_price" value="{{ old('compare_at_price',$course->compare_at_price) }}" class="admin-form__input" min="0" step="1000">
            </div>
          </div>
        </div>

        <div class="admin-form__field">
          <div class="admin-form__grid admin-form__grid--3">
            <div>
              <label class="admin-form__label">Trạng thái *</label>
              <select name="status" class="admin-form__select" required>
                <option value="draft" {{ old('status',$course->status)=='draft'?'selected':'' }}>Draft</option>
                <option value="published" {{ old('status',$course->status)=='published'?'selected':'' }}>Published</option>
                <option value="hidden" {{ old('status',$course->status)=='hidden'?'selected':'' }}>Hidden</option>
                <option value="archived" {{ old('status',$course->status)=='archived'?'selected':'' }}>Archived</option>
              </select>
            </div>
            <div>
              <label class="admin-form__label">Cấp độ</label>
              <select name="level" class="admin-form__select">
                <option value="">Chọn cấp độ</option>
                <option value="beginner" {{ old('level',$course->level)=='beginner'?'selected':'' }}>Cơ bản</option>
                <option value="intermediate" {{ old('level',$course->level)=='intermediate'?'selected':'' }}>Trung bình</option>
                <option value="advanced" {{ old('level',$course->level)=='advanced'?'selected':'' }}>Nâng cao</option>
              </select>
            </div>
            <div>
              <label class="admin-form__label">Ngôn ngữ</label>
              <input name="language" value="{{ old('language',$course->language ?? 'Vietnamese') }}" class="admin-form__input">
            </div>
          </div>
        </div>

        <div class="admin-form__field">
          <label class="admin-form__label">Tóm tắt ngắn</label>
          <textarea name="short_description" class="admin-form__textarea" rows="3">{{ old('short_description',$course->short_description) }}</textarea>
        </div>

        <div class="admin-form__field">
          <label class="admin-form__label">Ảnh thumbnail (tên file trong public/img/courses/)</label>
          <input name="thumbnail_path" value="{{ old('thumbnail_path',$course->thumbnail_path) }}" class="admin-form__input" placeholder="example.jpg">
        </div>

        <div class="admin-form__field">
          <label class="admin-form__label">Mô tả chi tiết (HTML)</label>
          <textarea id="editor" name="description_html" rows="10">{{ old('description_html',$course->description_html) }}</textarea>
        </div>

        <div class="admin-form__actions">
          <button type="submit" class="btn btn--primary">{{ $course->exists ? 'Lưu thay đổi' : 'Tạo mới' }}</button>
          @if($course->exists)
            <a class="btn btn--outline" href="{{ route('courses.show',$course->slug) }}" target="_blank">Xem trang</a>
          @endif
        </div>
      </form>

      <!-- Sections & Lessons Management -->
      @if($course->exists)
        <div class="admin-content-management">
          <div class="admin-content-management__header">
            <h3 class="admin-content-management__title">Nội dung khóa học (Sections & Lessons)</h3>
          </div>

          @foreach($course->sections()->with('lessons')->orderBy('position')->get() as $section)
            <div class="admin-section">
              <div class="admin-section__header">
                <div class="admin-flex--1">
                  <strong class="admin-section__title">{{ $section->title }}</strong>
                  <span class="admin-section__meta">({{ $section->lessons->count() }} bài học)</span>
                </div>
                <div class="admin-section__actions">
                  <button onclick="editSection({{ $section->id }}, '{{ $section->title }}', {{ $section->position }})" 
                          class="btn btn--outline btn--sm">
                    Sửa
                  </button>
                  <form action="{{ route('admin.sections.destroy', $section) }}" method="POST" class="admin-actions-container--inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Xóa phần này sẽ xóa tất cả bài học bên trong. Bạn có chắc?')" 
                            class="btn btn--danger btn--sm">
                      Xóa
                    </button>
                  </form>
                </div>
              </div>
              
              <div>
                @foreach($section->lessons()->orderBy('position')->get() as $lesson)
                  <div class="admin-lesson">
                    <div class="admin-lesson__content">
                      <div class="admin-lesson__title">{{ $lesson->title }}</div>
                      <div class="admin-lesson__meta">
                        {{ \App\Helpers\VideoHelper::formatDuration($lesson->duration) }}
                        @if($lesson->is_preview)
                          <span class="admin-lesson__preview">Preview</span>
                        @endif
                      </div>
                    </div>
                    <div class="admin-lesson__actions">
                      <button onclick="editLesson({{ $lesson->id }}, {{ $section->id }}, '{{ addslashes($lesson->title) }}', '{{ $lesson->video_path ?? '' }}', '{{ $lesson->video_url ?? '' }}', '{{ $lesson->attachment_path ?? '' }}', {{ $lesson->duration ?? 0 }}, {{ $lesson->is_preview ? 'true' : 'false' }}, {{ $lesson->position ?? 0 }})" 
                              class="btn btn--outline btn--sm">
                        Sửa
                      </button>
                      <form action="{{ route('admin.lessons.destroy', $lesson) }}" method="POST" class="admin-actions-container--inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Bạn có chắc muốn xóa bài học này?')" 
                                class="btn btn--danger btn--sm">
                          Xóa
                        </button>
                      </form>
                    </div>
                  </div>
                @endforeach
                
                <div class="admin-lesson__add">
                  <button onclick="showAddLessonForm({{ $section->id }})" 
                          class="btn btn--success">
                    + Thêm bài học
                  </button>
                </div>
              </div>
            </div>
          @endforeach

          <form action="{{ route('admin.sections.store', $course) }}" method="POST" class="admin-section__add-form">
            @csrf
            <input type="text" name="title" placeholder="Tên phần mới..." required 
                   class="admin-section__add-input">
            <button type="submit" class="btn btn--primary">
              + Thêm phần
            </button>
          </form>
        </div>
      @endif
    </div>

    <!-- Sidebar -->
    <aside class="admin-form-sidebar">
      <div class="admin-form-sidebar__card">
        <h3 class="admin-form-sidebar__title">Thông tin khóa học</h3>
        @if($course->exists)
          <div class="admin-form-sidebar__item">
            <p class="admin-form-sidebar__item-label">ID</p>
            <p class="admin-form-sidebar__item-value">{{ $course->id }}</p>
          </div>
          <div class="admin-form-sidebar__item">
            <p class="admin-form-sidebar__item-label">Ngày tạo</p>
            <p class="admin-form-sidebar__item-value">{{ $course->created_at->format('d/m/Y H:i') }}</p>
          </div>
          <div class="admin-form-sidebar__item">
            <p class="admin-form-sidebar__item-label">Học viên</p>
            <p class="admin-form-sidebar__item-value">{{ $course->enrolled_students }}</p>
          </div>
          <div class="admin-form-sidebar__item">
            <p class="admin-form-sidebar__item-label">Đánh giá</p>
            <p class="admin-form-sidebar__item-value">{{ number_format($course->rating, 1) }} ⭐ ({{ $course->rating_count }})</p>
          </div>
        @endif
      </div>
    </aside>
  </div>
</div>

<!-- Modals for Section & Lesson -->
<div id="sectionModal" class="admin-modal">
  <div class="admin-modal__content admin-modal__content--small">
    <h3 class="admin-modal__title">Sửa phần</h3>
    <form id="sectionForm" method="POST">
      @csrf
      @method('PUT')
      <div class="admin-modal__field">
        <label class="admin-form__label">Tên phần</label>
        <input type="text" name="title" id="sectionTitle" required class="admin-form__input">
      </div>
      <div class="admin-modal__field admin-modal__field--last">
        <label class="admin-form__label">Vị trí</label>
        <input type="number" name="position" id="sectionPosition" class="admin-form__input">
      </div>
      <div class="admin-modal__actions">
        <button type="submit" class="admin-modal__submit">Lưu</button>
        <button type="button" onclick="document.getElementById('sectionModal').classList.remove('admin-modal--active')" class="admin-modal__cancel">Hủy</button>
      </div>
    </form>
  </div>
</div>

<div id="lessonModal" class="admin-modal">
  <div class="admin-modal__content">
    <h3 class="admin-modal__title" id="lessonModalTitle">Thêm bài học</h3>
    <form id="lessonForm" method="POST" enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="section_id" id="lessonSectionId">
      <div class="admin-modal__field">
        <label class="admin-form__label">Tên bài học *</label>
        <input type="text" name="title" id="lessonTitle" required class="admin-form__input">
      </div>
      
      <!-- Video Section -->
      <div class="admin-form-section">
        <h4 class="admin-form-section__title">Video bài học</h4>
        
        <div class="admin-form-section__field">
          <label class="admin-form__label">Tải lên video file</label>
          <input type="file" name="video_file" id="lessonVideoFile" accept="video/*" class="admin-form__input">
          <small class="admin-form-section__help">Định dạng: MP4, AVI, MOV, WMV, FLV, WEBM (tối đa 1.3GB)</small>
        </div>
        
        <div class="admin-form-section__field">
          <label class="admin-form__label">Hoặc Link URL video (YouTube, Vimeo, Google Drive, etc.)</label>
          <div style="position: relative;">
            <input type="url" name="video_url" id="lessonVideoUrl" placeholder="https://www.youtube.com/watch?v=... hoặc https://drive.google.com/file/d/..." 
                   class="admin-form__input">
            <span id="youtubeDurationLoader" style="display: none; position: absolute; right: 10px; top: 50%; transform: translateY(-50%); color: #667eea;">
              <i class="fas fa-spinner fa-spin"></i> Đang lấy thời lượng...
            </span>
            <span id="youtubeDurationSuccess" style="display: none; position: absolute; right: 10px; top: 50%; transform: translateY(-50%); color: #10b981; font-size: 12px;">
              <i class="fas fa-check-circle"></i> <span id="youtubeDurationText"></span>
            </span>
            <span id="youtubeDurationError" style="display: none; position: absolute; right: 10px; top: 50%; transform: translateY(-50%); color: #ef4444; font-size: 12px;">
              <i class="fas fa-exclamation-circle"></i> <span id="youtubeDurationErrorText"></span>
            </span>
          </div>
          <small class="admin-form-section__help">
            Hỗ trợ: YouTube, Vimeo, Google Drive, hoặc link video trực tiếp. Thời lượng YouTube sẽ được tự động lấy.
          </small>
          <div class="admin-form-section__note">
            <strong>Lưu ý Google Drive:</strong> 
            <ul>
              <li>File phải được chia sẻ công khai (Anyone with the link)</li>
              <li>Click chuột phải vào file → "Get link" → Chọn "Anyone with the link"</li>
              <li>Định dạng hỗ trợ: https://drive.google.com/file/d/FILE_ID/view hoặc https://drive.google.com/open?id=FILE_ID</li>
              <li>Video sẽ được phát trực tiếp từ Google Drive (không dùng iframe)</li>
            </ul>
          </div>
        </div>
        
        <div class="admin-form-section__field admin-form-section__field--last">
          <label class="admin-form__label">Hoặc đường dẫn file đã có (tùy chọn)</label>
          <input type="text" name="video_path" id="lessonVideoPath" placeholder="videos/lesson1.mp4" 
                 class="admin-form__input">
          <small class="admin-form-section__help">Đường dẫn file trong storage nếu đã upload trước đó</small>
        </div>
      </div>
      
      <!-- Attachment Section -->
      <div class="admin-form-section">
        <h4 class="admin-form-section__title">Tài liệu đính kèm</h4>
        
        <div class="admin-form-section__field">
          <label class="admin-form__label">Tải lên tài liệu</label>
          <input type="file" name="attachment_file" id="lessonAttachmentFile" 
                 accept=".pdf,.doc,.docx,.zip,.rar" 
                 class="admin-form__input">
          <small class="admin-form-section__help">Định dạng: PDF, DOC, DOCX, ZIP, RAR (tối đa 1.3GB)</small>
        </div>
        
        <div class="admin-form-section__field admin-form-section__field--last">
          <label class="admin-form__label">Hoặc đường dẫn file đã có (tùy chọn)</label>
          <input type="text" name="attachment_path" id="lessonAttachmentPath" placeholder="attachments/file.pdf" 
                 class="admin-form__input">
          <small class="admin-form-section__help">Đường dẫn file trong storage nếu đã upload trước đó</small>
        </div>
      </div>
      
      <div class="admin-modal__field">
        <div class="admin-form__grid admin-form__grid--2">
          <div>
            <label class="admin-form__label">Thời lượng (phút)</label>
            <input type="number" name="duration" id="lessonDuration" min="0" value="0" class="admin-form__input">
            <small class="admin-form-section__help">
              Tự động tính từ video file hoặc YouTube API. Với video URL khác (Vimeo/Google Drive) cần nhập thủ công hoặc để 0.
            </small>
          </div>
          <div>
            <label class="admin-form__label">Vị trí</label>
            <input type="number" name="position" id="lessonPosition" min="0" class="admin-form__input">
            <small class="admin-form-section__help">
              Tự động đặt ở cuối nếu để trống. Vị trí xác định thứ tự hiển thị bài học.
            </small>
          </div>
        </div>
      </div>
      
      <div class="admin-modal__field admin-modal__field--last">
        <label class="admin-flex admin-flex--center-items admin-flex--gap-sm" style="cursor: pointer;">
          <input type="checkbox" name="is_preview" id="lessonIsPreview">
          <span>Cho phép xem trước (Preview)</span>
        </label>
      </div>
      
      <div class="admin-modal__actions">
        <button type="submit" class="admin-modal__submit">Lưu</button>
        <button type="button" onclick="document.getElementById('lessonModal').classList.remove('admin-modal--active')" class="admin-modal__cancel">Hủy</button>
      </div>
    </form>
  </div>
</div>

<script>
function editSection(id, title, position) {
  document.getElementById('sectionForm').action = `/admin/sections/${id}`;
  document.getElementById('sectionTitle').value = title;
  document.getElementById('sectionPosition').value = position;
  document.getElementById('sectionModal').classList.add('admin-modal--active');
}

// Close modal when clicking outside
document.getElementById('sectionModal')?.addEventListener('click', function(e) {
  if (e.target === this) {
    this.classList.remove('admin-modal--active');
  }
});

document.getElementById('lessonModal')?.addEventListener('click', function(e) {
  if (e.target === this) {
    this.classList.remove('admin-modal--active');
  }
});

function showAddLessonForm(sectionId) {
  document.getElementById('lessonModalTitle').textContent = 'Thêm bài học';
  const form = document.getElementById('lessonForm');
  form.action = `/admin/sections/${sectionId}/lessons`;
  form.method = 'POST';
  form.enctype = 'multipart/form-data';
  
  // Remove _method if exists
  const methodInput = form.querySelector('input[name="_method"]');
  if (methodInput) methodInput.remove();
  
  document.getElementById('lessonSectionId').value = sectionId;
  document.getElementById('lessonTitle').value = '';
  document.getElementById('lessonVideoFile').value = '';
  document.getElementById('lessonVideoUrl').value = '';
  document.getElementById('lessonVideoPath').value = '';
  document.getElementById('lessonAttachmentFile').value = '';
  document.getElementById('lessonAttachmentPath').value = '';
  document.getElementById('lessonDuration').value = '';
  document.getElementById('lessonPosition').value = '';
  document.getElementById('lessonIsPreview').checked = false;
  
  // Reset YouTube duration indicators
  resetYouTubeDurationIndicators();
  
  document.getElementById('lessonModal').classList.add('admin-modal--active');
}

function editLesson(id, sectionId, title, videoPath, videoUrl, attachmentPath, duration, isPreview, position) {
  document.getElementById('lessonModalTitle').textContent = 'Sửa bài học';
  const form = document.getElementById('lessonForm');
  form.action = `/admin/lessons/${id}`;
  form.method = 'POST';
  form.enctype = 'multipart/form-data';
  
  // Add _method for PUT
  if (!form.querySelector('input[name="_method"]')) {
    const methodInput = document.createElement('input');
    methodInput.type = 'hidden';
    methodInput.name = '_method';
    methodInput.value = 'PUT';
    form.appendChild(methodInput);
  }
  
  document.getElementById('lessonSectionId').value = sectionId;
  document.getElementById('lessonTitle').value = title || '';
  document.getElementById('lessonVideoPath').value = videoPath || '';
  document.getElementById('lessonVideoUrl').value = videoUrl || '';
  document.getElementById('lessonAttachmentPath').value = attachmentPath || '';
  document.getElementById('lessonDuration').value = duration || '';
  document.getElementById('lessonPosition').value = position || '';
  document.getElementById('lessonIsPreview').checked = isPreview;
  
  // Reset YouTube duration indicators
  resetYouTubeDurationIndicators();
  
  // If YouTube URL exists, try to fetch duration
  if (videoUrl && isYouTubeUrl(videoUrl)) {
    fetchYouTubeDuration(videoUrl);
  }
  
  document.getElementById('lessonModal').classList.add('admin-modal--active');
}

// YouTube Duration Auto-fetch
function isYouTubeUrl(url) {
  if (!url) return false;
  return /youtube\.com|youtu\.be/.test(url);
}

function resetYouTubeDurationIndicators() {
  document.getElementById('youtubeDurationLoader').style.display = 'none';
  document.getElementById('youtubeDurationSuccess').style.display = 'none';
  document.getElementById('youtubeDurationError').style.display = 'none';
}

function fetchYouTubeDuration(videoUrl) {
  if (!videoUrl || !isYouTubeUrl(videoUrl)) {
    return;
  }

  const loader = document.getElementById('youtubeDurationLoader');
  const success = document.getElementById('youtubeDurationSuccess');
  const error = document.getElementById('youtubeDurationError');
  const errorText = document.getElementById('youtubeDurationErrorText');
  const durationText = document.getElementById('youtubeDurationText');
  const durationInput = document.getElementById('lessonDuration');

  // Reset indicators
  resetYouTubeDurationIndicators();
  loader.style.display = 'block';

  // Call API
  fetch('{{ route("admin.api.youtube.duration") }}', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': '{{ csrf_token() }}'
    },
    body: JSON.stringify({ video_url: videoUrl })
  })
  .then(response => response.json())
  .then(data => {
    loader.style.display = 'none';
    
    if (data.duration && data.duration > 0) {
      // Success - auto-fill duration
      durationInput.value = data.duration;
      durationText.textContent = data.formatted || `${data.duration} phút`;
      success.style.display = 'block';
      
      // Hide success message after 3 seconds
      setTimeout(() => {
        success.style.display = 'none';
      }, 3000);
    } else {
      // Error
      errorText.textContent = data.error || 'Không thể lấy thời lượng';
      error.style.display = 'block';
    }
  })
  .catch(err => {
    loader.style.display = 'none';
    errorText.textContent = 'Lỗi kết nối API';
    error.style.display = 'block';
    console.error('YouTube API error:', err);
  });
}

// Auto-fetch duration when YouTube URL is entered
document.addEventListener('DOMContentLoaded', function() {
  const videoUrlInput = document.getElementById('lessonVideoUrl');
  if (videoUrlInput) {
    let debounceTimer;
    
    videoUrlInput.addEventListener('input', function() {
      const url = this.value.trim();
      
      // Clear previous timer
      clearTimeout(debounceTimer);
      
      // Reset indicators if URL is cleared
      if (!url) {
        resetYouTubeDurationIndicators();
        return;
      }
      
      // Debounce: wait 1 second after user stops typing
      debounceTimer = setTimeout(() => {
        if (isYouTubeUrl(url)) {
          fetchYouTubeDuration(url);
        } else {
          resetYouTubeDurationIndicators();
        }
      }, 1000);
    });
    
    // Also fetch on blur (when user leaves the field)
    videoUrlInput.addEventListener('blur', function() {
      const url = this.value.trim();
      if (url && isYouTubeUrl(url)) {
        fetchYouTubeDuration(url);
      }
    });
  }
});
</script>

{{-- CKEditor 5 CDN --}}
<script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
<script>
ClassicEditor.create(document.querySelector('#editor'), {
  toolbar: ['heading','|','bold','italic','link','bulletedList','numberedList','blockQuote','|','undo','redo']
}).catch(console.error);
</script>
@endsection
