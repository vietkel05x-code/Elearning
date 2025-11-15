@extends('layouts.app')

@section('title', $course->title)

@push('styles')
<link rel="stylesheet" href="{{ asset('css/pages/courses.css') }}">
@endpush

@section('content')
<section class="course-detail-page">
  @if(session('success'))
    <div class="alert alert--success">{{ session('success') }}</div>
  @endif

  @if(session('error'))
    <div class="alert alert--error">{{ session('error') }}</div>
  @endif

  <div class="course-detail-grid">
    <div class="course-detail__main">
      <h1 class="course-detail__title">{{ $course->title }}</h1>
      
      <div class="course-detail__meta">
        <div class="course-detail__rating">
          <span class="course-detail__rating-score">{{ number_format($course->rating, 1) }}</span>
          <div class="course-detail__rating-stars">
            @for($i = 0; $i < 5; $i++)
              <i class="fa fa-star{{ $i < floor($course->rating) ? '' : '-o' }}"></i>
            @endfor
          </div>
          <span class="course-detail__rating-count">({{ $course->rating_count }} đánh giá)</span>
        </div>
        <span class="course-detail__meta-separator">·</span>
        <span class="course-detail__meta-item">{{ $course->enrolled_students }} học viên</span>
        <span class="course-detail__meta-separator">·</span>
        <span class="course-detail__meta-item">{{ $course->total_duration }} giờ</span>
      </div>

      <div class="course-detail__level">
        <strong>{{ ucfirst($course->level ?? 'Beginner') }}</strong> ·
        {{ $course->language ?? 'Vietnamese' }}
      </div>

      @if($course->instructor)
        <div class="course-detail__instructor">
          <div class="course-detail__instructor-avatar">
            {{ strtoupper(substr($course->instructor->name, 0, 1)) }}
          </div>
          <div>
            <p class="course-detail__instructor-name">Giảng viên: {{ $course->instructor->name }}</p>
            <p class="course-detail__instructor-courses">{{ $course->instructor->courses()->count() }} khóa học</p>
          </div>
        </div>
      @endif

      @if($course->thumbnail_path)
        <img src="{{ $course->thumbnail_url }}" alt="{{ $course->title }}" class="course-detail__thumbnail">
      @endif

      @if($course->short_description)
        <div class="course-detail__short-desc">
          <p>{{ $course->short_description }}</p>
        </div>
      @endif

      @if($course->description_html)
        <div class="course-detail__description">
          <h2 class="course-detail__description-title">Về khóa học</h2>
          {!! $course->description_html !!}
        </div>
      @endif

      <!-- Course Content (Sections & Lessons) -->
      @if($course->sections->count() > 0)
        <div class="course-content">
          <h2 class="course-content__title">Nội dung khóa học</h2>
          <div class="course-content__list">
            @foreach($course->sections as $section)
              <div class="course-content__section" data-section-id="{{ $section->id }}">
                <div class="course-content__section-header">
                  <span>{{ $section->title }} ({{ $section->lessons->count() }} bài học)</span>
                  <button class="course-content__section-toggle" type="button" aria-label="Thu gọn/mở rộng">
                    <i class="fas fa-chevron-down"></i>
                  </button>
                </div>
                <div class="course-content__lessons">
                  @foreach($section->lessons as $lesson)
                    <div class="course-content__lesson">
                      <i class="fa fa-play-circle course-content__lesson-icon"></i>
                      <span class="course-content__lesson-title">{{ $lesson->title }}</span>
                      <span class="course-content__lesson-duration">{{ \App\Helpers\VideoHelper::formatDuration($lesson->duration) }}</span>
                      @if($lesson->is_preview)
                        <span class="course-content__lesson-badge">Preview</span>
                      @endif
                    </div>
                  @endforeach
                </div>
              </div>
            @endforeach
          </div>
        </div>
      @endif

      <!-- Reviews Section -->
      <div class="course-reviews">
        <h2 class="course-reviews__title">Đánh giá và nhận xét</h2>

        @auth
          @if($isEnrolled)
            @php
              $userReview = $course->reviews()->where('user_id', Auth::id())->first();
            @endphp
            
            @if($userReview)
              <div class="card" style="margin-bottom: var(--spacing-lg);">
                <h3 style="margin: 0 0 var(--spacing-md) 0; font-size: var(--font-size-lg);">Đánh giá của bạn</h3>
                <div style="display: flex; align-items: center; gap: var(--spacing-sm); margin-bottom: var(--spacing-sm);">
                  @for($i = 1; $i <= 5; $i++)
                    <i class="fa fa-star{{ $i <= $userReview->rating ? '' : '-o' }}" style="color: #f3ca8c; font-size: var(--font-size-xl);"></i>
                  @endfor
                </div>
                @if($userReview->content)
                  <p style="margin: 0; color: var(--color-text-secondary);">{{ $userReview->content }}</p>
                @endif
                <form action="{{ route('reviews.destroy', $userReview) }}" method="POST" style="margin-top: var(--spacing-md);">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn--danger btn--sm">Xóa đánh giá</button>
                </form>
              </div>
            @else
              <!-- Review Form -->
              <div class="course-reviews__form">
                <h3 class="course-reviews__form-title">Viết đánh giá</h3>
                <form action="{{ route('reviews.store', $course) }}" method="POST">
                  @csrf
                  <div style="margin-bottom: var(--spacing-md);">
                    <label style="display: block; margin-bottom: var(--spacing-sm); font-weight: bold;">Đánh giá *</label>
                    <div class="course-reviews__stars" id="ratingStars">
                      @for($i = 1; $i <= 5; $i++)
                        <i class="fa fa-star-o course-reviews__star" data-rating="{{ $i }}" onmouseover="hoverStar({{ $i }})" onclick="selectRating({{ $i }})"></i>
                      @endfor
                    </div>
                    <input type="hidden" name="rating" id="ratingInput" value="5" required>
                  </div>
                  <div style="margin-bottom: var(--spacing-md);">
                    <label for="content" style="display: block; margin-bottom: var(--spacing-sm); font-weight: bold;">Nhận xét</label>
                    <textarea name="content" id="content" rows="4" class="course-reviews__textarea" placeholder="Chia sẻ trải nghiệm của bạn về khóa học này..."></textarea>
                  </div>
                  <button type="submit" class="btn btn--primary">Gửi đánh giá</button>
                </form>
              </div>
            @endif
          @endif
        @endauth

        <!-- Reviews List -->
        @if($course->reviews->count() > 0)
          <div class="course-reviews__list">
            @foreach($course->reviews as $review)
              <div class="course-review">
                <div class="course-review__header">
                  <div>
                    <p class="course-review__user">{{ $review->user->name }}</p>
                    <p class="course-review__date">{{ $review->created_at->format('d/m/Y') }}</p>
                  </div>
                  <div class="course-review__rating">
                    @for($i = 1; $i <= 5; $i++)
                      <i class="fa fa-star{{ $i <= $review->rating ? '' : '-o' }} course-review__rating-star"></i>
                    @endfor
                  </div>
                </div>
                @if($review->content)
                  <p class="course-review__content">{{ $review->content }}</p>
                @endif
              </div>
            @endforeach
          </div>
        @else
          <p class="course-reviews__empty">Chưa có đánh giá nào</p>
        @endif
      </div>
    </div>

    <aside class="course-sidebar">
      <div class="course-sidebar__card card">
        <div class="course-sidebar__price">
          ₫{{ number_format($course->price ?? 0, 0, ',', '.') }}
          @if($course->compare_at_price)
            <span class="course-sidebar__price-old">
              ₫{{ number_format($course->compare_at_price, 0, ',', '.') }}
            </span>
          @endif
        </div>
        @auth
          @if($isEnrolled)
            <a href="{{ route('student.learn', $course->slug) }}" class="btn btn--success btn--full" style="margin-top: var(--spacing-md);">
              Tiếp tục học
            </a>
          @else
            <form action="{{ route('cart.add', $course->id) }}" method="POST">
              @csrf
              <button type="submit" class="btn btn--primary btn--full" style="margin-top: var(--spacing-md);">
                Thêm vào giỏ hàng
              </button>
            </form>
          @endif
        @else
          <a href="{{ route('login') }}" class="btn btn--primary btn--full" style="margin-top: var(--spacing-md);">
            Đăng nhập để mua
          </a>
        @endauth
        <ul class="course-sidebar__features">
          <li>Lifetime access</li>
          <li>Certificate of completion</li>
          <li>{{ $course->video_count }} video bài học</li>
          <li>{{ $course->total_duration }} giờ nội dung</li>
        </ul>
      </div>
    </aside>
  </div>
</section>

<script>
let selectedRating = 5;

function hoverStar(rating) {
  const stars = document.querySelectorAll('#ratingStars i');
  stars.forEach((star, index) => {
    if (index < rating) {
      star.classList.remove('fa-star-o');
      star.classList.add('fa-star');
      star.classList.add('active');
    } else {
      star.classList.remove('fa-star');
      star.classList.remove('active');
      star.classList.add('fa-star-o');
    }
  });
}

function selectRating(rating) {
  selectedRating = rating;
  document.getElementById('ratingInput').value = rating;
  const stars = document.querySelectorAll('#ratingStars i');
  stars.forEach((star, index) => {
    if (index < rating) {
      star.classList.remove('fa-star-o');
      star.classList.add('fa-star');
      star.classList.add('active');
    } else {
      star.classList.remove('fa-star');
      star.classList.remove('active');
      star.classList.add('fa-star-o');
    }
  });
}

document.addEventListener('DOMContentLoaded', function() {
  selectRating(5);
  
  // Section collapse/expand functionality
  document.querySelectorAll('.course-content__section-toggle').forEach(toggle => {
    toggle.addEventListener('click', function() {
      const section = this.closest('.course-content__section');
      const lessons = section.querySelector('.course-content__lessons');
      const icon = this.querySelector('i');
      
      if (lessons) {
        const isExpanded = !lessons.classList.contains('course-content__lessons--collapsed');
        
        if (isExpanded) {
          lessons.classList.add('course-content__lessons--collapsed');
          icon.classList.remove('fa-chevron-down');
          icon.classList.add('fa-chevron-right');
        } else {
          lessons.classList.remove('course-content__lessons--collapsed');
          icon.classList.remove('fa-chevron-right');
          icon.classList.add('fa-chevron-down');
        }
      }
    });
  });
});
</script>
@endsection
