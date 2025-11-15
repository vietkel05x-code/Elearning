@extends('layouts.app')

@section('title', $lesson->title . ' - ' . $course->title)

@push('styles')
<link rel="stylesheet" href="{{ asset('css/pages/student-lesson.css') }}">
@endpush

@section('content')
<!-- Breadcrumb -->
<nav class="breadcrumb" style="margin-bottom: var(--spacing-lg);">
  <a href="{{ route('student.courses') }}">Khóa học của tôi</a>
  <span style="margin: 0 var(--spacing-sm);">/</span>
  <a href="{{ route('student.learn', $course->slug) }}">{{ $course->title }}</a>
  <span style="margin: 0 var(--spacing-sm);">/</span>
  <span>{{ $lesson->title }}</span>
</nav>

<section class="lesson-page">
  <div class="lesson-grid">
    <!-- Sidebar: Course Content -->
    <aside class="lesson-sidebar">
      @php
        // Calculate course progress
        $totalLessons = $course->sections->sum(function($s) {
          return $s->lessons->count();
        });
        $completedLessons = count($progress);
        $courseProgress = $totalLessons > 0 ? round(($completedLessons / $totalLessons) * 100) : 0;
        $currentLessonId = $lesson->id;
      @endphp
      
      @include('student.partials.sidebar', ['currentLessonId' => $lesson->id])
    </aside>

    <!-- Main Content: Lesson Player -->
    <main class="lesson-main">
      <!-- Course Title -->
      <div class="lesson-course-title" style="margin-bottom: var(--spacing-md);">
        <h2 style="font-size: var(--font-size-xl); font-weight: 600; color: var(--color-text); margin: 0;">
          {{ $course->title }}
        </h2>
      </div>

      @if($isLocked)
        <div class="lesson-locked">
          <div class="lesson-locked__icon">🔒</div>
          <h2 class="lesson-locked__title">Bài học này đang bị khóa</h2>
          <p class="lesson-locked__message">{{ $lockedReason }}</p>
          @if($previousLesson)
            <a href="{{ route('student.lesson', ['course' => $course->slug, 'lesson' => $previousLesson->id]) }}" 
               class="lesson-locked__button">
              Quay lại bài học trước
            </a>
          @endif
        </div>
      @endif

      <div class="lesson-video {{ $isLocked ? 'lesson-video--locked' : '' }}">
        @php
          $videoEmbedUrl = null;
          $directVideoUrl = null;
          $useIframe = false;
          
          if ($lesson->video_url) {
            if (\App\Helpers\VideoHelper::shouldUseIframe($lesson->video_url)) {
              $videoEmbedUrl = \App\Helpers\VideoHelper::getEmbedUrl($lesson->video_url);
              $useIframe = true;
            } 
            elseif (\App\Helpers\VideoHelper::isGoogleDrive($lesson->video_url)) {
              $directVideoUrl = \App\Helpers\VideoHelper::getDirectVideoUrl($lesson->video_url);
            }
            else {
              $directVideoUrl = $lesson->video_url;
            }
          }
        @endphp

        @if($useIframe && $videoEmbedUrl)
          <iframe id="lessonVideoIframe" src="{{ $videoEmbedUrl }}?enablejsapi=1" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        @elseif($directVideoUrl)
          <video id="lessonVideo" controls controlsList="nodownload">
            <source src="{{ $directVideoUrl }}" type="video/mp4">
            <div class="lesson-video__fallback">
              <p>
                Trình duyệt của bạn không hỗ trợ video. 
                @if(\App\Helpers\VideoHelper::isGoogleDrive($lesson->video_url ?? ''))
                  <br><small>Nếu video không hiển thị, vui lòng đảm bảo file Google Drive được chia sẻ công khai (Anyone with the link)</small>
                @endif
              </p>
            </div>
          </video>
        @elseif($lesson->video_path)
          <video id="lessonVideo" controls controlsList="nodownload">
            <source src="{{ Storage::url($lesson->video_path) }}" type="video/mp4">
            <div class="lesson-video__fallback">
              <p>Trình duyệt của bạn không hỗ trợ video.</p>
            </div>
          </video>
        @else
          <div class="lesson-video__fallback">
            <p>Video chưa được tải lên</p>
          </div>
        @endif
      </div>

      <!-- Warning Alert for Fast Seeking -->
      <div id="seekWarning" class="lesson-seek-warning" style="display: none;">
        <div class="lesson-seek-warning__content">
          <i class="fas fa-exclamation-triangle"></i>
          <span>⚠️ Bạn đang tua video quá nhanh. Vui lòng xem video một cách bình thường để đảm bảo chất lượng học tập.</span>
        </div>
      </div>

      <div class="lesson-info card">
        <div class="lesson-info__header">
          <div>
            <h1 class="lesson-info__title">{{ $lesson->title }}</h1>
            <p class="lesson-info__meta">
              {{ $lesson->section->title }} • {{ \App\Helpers\VideoHelper::formatDuration($lesson->duration) }}
            </p>
            <div id="videoProgress" style="margin-top: var(--spacing-sm); font-size: var(--font-size-sm); color: var(--color-text-secondary);">
              <span>Tiến độ: <span id="progressPercent">0%</span></span>
            </div>
          </div>
          @if($isLocked)
            <span class="lesson-info__status lesson-info__status--locked">
              🔒 Đang khóa
            </span>
          @elseif(!isset($progress[$lesson->id]))
            {{-- Nút đánh dấu hoàn thành đã bị ẩn - tự động hoàn thành khi xem đến 85% video --}}
            <span class="lesson-info__status lesson-info__status--in-progress" style="display: none;" id="inProgressStatus">
              ⏳ Đang xem...
            </span>
          @else
            <span class="lesson-info__status lesson-info__status--completed">
              ✓ Đã hoàn thành
            </span>
          @endif
        </div>

        @if($lesson->attachment_path)
          <div class="lesson-attachment">
            <a href="{{ Storage::url($lesson->attachment_path) }}" 
               download class="lesson-attachment__link">
              <span>📎</span>
              <span>Tải tài liệu đính kèm</span>
            </a>
          </div>
        @endif
      </div>

      <!-- Navigation -->
      <div class="lesson-navigation">
        @if($previousLesson)
          <a href="{{ route('student.lesson', ['course' => $course->slug, 'lesson' => $previousLesson->id]) }}" 
             class="lesson-navigation__link lesson-navigation__link--prev">
            ← Bài trước: {{ $previousLesson->title }}
          </a>
        @else
          <div class="lesson-navigation__spacer"></div>
        @endif

        @if($nextLesson)
          <a href="{{ route('student.lesson', ['course' => $course->slug, 'lesson' => $nextLesson->id]) }}" 
             class="lesson-navigation__link lesson-navigation__link--next">
            Bài tiếp theo: {{ $nextLesson->title }} →
          </a>
        @else
          <div class="lesson-navigation__spacer"></div>
        @endif
      </div>
    </main>
  </div>
</section>

<script>
function completeLesson() {
  // Check if already completed
  const completedStatus = document.querySelector('.lesson-info__status--completed');
  if (completedStatus) {
    return; // Already completed
  }

  fetch('{{ route("student.complete-lesson", $lesson->id) }}', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': '{{ csrf_token() }}'
    }
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      // Update status in header
      const statusContainer = document.querySelector('.lesson-info__header');
      const inProgressStatus = document.getElementById('inProgressStatus');
      if (inProgressStatus) {
        inProgressStatus.outerHTML = '<span class="lesson-info__status lesson-info__status--completed">✓ Đã hoàn thành</span>';
      } else {
        // Find and replace status
        const statusElements = statusContainer.querySelectorAll('.lesson-info__status');
        statusElements.forEach(el => {
          if (!el.classList.contains('lesson-info__status--completed')) {
            el.outerHTML = '<span class="lesson-info__status lesson-info__status--completed">✓ Đã hoàn thành</span>';
          }
        });
      }
      
      // Update sidebar - mark lesson as completed
      const currentLessonItem = document.querySelector('.lesson-item--current');
      if (currentLessonItem) {
        currentLessonItem.classList.remove('lesson-item--current', 'lesson-item--normal');
        currentLessonItem.classList.add('lesson-item--completed');
        
        // Update icon
        const icon = currentLessonItem.querySelector('.lesson-item__icon');
        if (icon) {
          icon.classList.remove('lesson-item__icon--current', 'lesson-item__icon--normal');
          icon.classList.add('lesson-item__icon--completed');
          icon.innerHTML = '<span>✓</span>';
        }
      }
      
      // Unlock next lesson - reload sidebar via API
      fetch('{{ route("admin.api.courses.sidebar", $course->slug) }}?lesson={{ $lesson->id }}', {
        headers: {
          'X-Requested-With': 'XMLHttpRequest',
          'Accept': 'application/json'
        }
      })
      .then(response => response.json())
      .then(data => {
        if (data.html) {
          const oldSidebar = document.querySelector('.lesson-sidebar');
          if (oldSidebar) {
            // Preserve current lesson highlight
            const currentLessonId = {{ $lesson->id }};
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = data.html;
            
            // Update progress section
            const newProgress = tempDiv.querySelector('.lesson-sidebar__progress');
            const oldProgress = oldSidebar.querySelector('.lesson-sidebar__progress');
            if (newProgress && oldProgress) {
              oldProgress.outerHTML = newProgress.outerHTML;
            }
            
            // Update sections
            const newSections = tempDiv.querySelector('.lesson-sidebar__sections');
            const oldSections = oldSidebar.querySelector('.lesson-sidebar__sections');
            if (newSections && oldSections) {
              // Preserve expanded/collapsed state
              const expandedSections = [];
              oldSections.querySelectorAll('.lesson-sidebar__section').forEach(section => {
                const lessons = section.querySelector('.lesson-sidebar__lessons');
                if (lessons && !lessons.classList.contains('lesson-sidebar__lessons--collapsed')) {
                  expandedSections.push(section.dataset.sectionId);
                }
              });
              
              oldSections.innerHTML = newSections.innerHTML;
              
              // Restore expanded state and highlight current lesson
              oldSections.querySelectorAll('.lesson-sidebar__section').forEach(section => {
                if (expandedSections.includes(section.dataset.sectionId)) {
                  const lessons = section.querySelector('.lesson-sidebar__lessons');
                  const toggle = section.querySelector('.lesson-sidebar__section-toggle i');
                  if (lessons) lessons.classList.remove('lesson-sidebar__lessons--collapsed');
                  if (toggle) {
                    toggle.classList.remove('fa-chevron-right');
                    toggle.classList.add('fa-chevron-down');
                  }
                }
                
                // Highlight current lesson
                const currentLink = section.querySelector(`a[href*="/lessons/{{ $lesson->id }}"]`);
                if (currentLink) {
                  currentLink.classList.add('lesson-item--current');
                  const icon = currentLink.querySelector('.lesson-item__icon');
                  if (icon) {
                    icon.classList.add('lesson-item__icon--current');
                  }
                }
              });
            }
            
            // Re-initialize collapse/expand
            initSectionToggles();
          }
        }
      })
      .catch(err => {
        console.error('Error reloading sidebar:', err);
        // Fallback: just reload page after delay
        setTimeout(() => location.reload(), 2000);
      });
    }
  })
  .catch(error => {
    console.error('Error:', error);
    alert('Có lỗi xảy ra khi đánh dấu hoàn thành!');
  });
}

document.addEventListener('DOMContentLoaded', function() {
  const COMPLETION_THRESHOLD = 0.85; // 85% to complete
  let maxWatchedTime = 0; // Track maximum time watched
  let lastTime = 0; // Track last time for seeking detection
  let isCompleted = false;

  // Handle video tag (direct video files)
  const video = document.getElementById('lessonVideo');
  if (video) {
    // Track video progress
    video.addEventListener('timeupdate', function() {
      if (isCompleted) return;
      
      const currentTime = video.currentTime;
      const duration = video.duration;
      
      if (duration > 0) {
        // Update max watched time
        if (currentTime > maxWatchedTime) {
          maxWatchedTime = currentTime;
        }
        
        // Calculate progress percentage
        const progress = (maxWatchedTime / duration) * 100;
        const progressElement = document.getElementById('progressPercent');
        if (progressElement) {
          progressElement.textContent = Math.round(progress) + '%';
        }
        
        // Check if reached 85%
        if (progress >= (COMPLETION_THRESHOLD * 100) && !isCompleted) {
          isCompleted = true;
          completeLesson();
        }
      }
      
      lastTime = currentTime;
    });

    // Detect fast seeking
    video.addEventListener('seeked', function() {
      const currentTime = video.currentTime;
      const timeJump = Math.abs(currentTime - lastTime);
      
      // If jump is more than 30 seconds, show warning
      if (timeJump > 30 && !isCompleted) {
        showSeekWarning();
      }
      
      lastTime = currentTime;
    });

    // Also handle ended event as backup
    video.addEventListener('ended', function() {
      if (!isCompleted) {
        isCompleted = true;
        completeLesson();
      }
    });
  }

  // Function to show seek warning
  function showSeekWarning() {
    const warning = document.getElementById('seekWarning');
    if (warning) {
      warning.style.display = 'block';
      // Hide after 5 seconds
      setTimeout(() => {
        warning.style.display = 'none';
      }, 5000);
    }
  }

  // Handle YouTube iframe
  const iframe = document.getElementById('lessonVideoIframe');
  if (iframe) {
    let youtubeIsCompleted = false;
    let player;
    let apiReady = false;
    let youtubeMaxWatchedTime = 0;
    let youtubeLastTime = 0;
    let youtubeDuration = 0;

    // Extract video ID from iframe src
    const videoId = iframe.src.match(/embed\/([^?]+)/)?.[1];
    
    if (videoId) {
      // Check if YouTube API is already loaded
      if (window.YT && window.YT.Player) {
        initializePlayer();
      } else {
        // Load YouTube IFrame API
        const tag = document.createElement('script');
        tag.src = "https://www.youtube.com/iframe_api";
        tag.async = true;
        const firstScriptTag = document.getElementsByTagName('script')[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

        // Initialize YouTube player when API is ready
        window.onYouTubeIframeAPIReady = function() {
          apiReady = true;
          initializePlayer();
        };
      }

      function initializePlayer() {
        try {
          // Wait a bit for iframe to be ready
          setTimeout(function() {
            try {
              player = new YT.Player(iframe, {
                events: {
                  'onReady': function(event) {
                    console.log('YouTube player ready');
                    youtubeDuration = player.getDuration();
                    // Start tracking progress
                    setInterval(function() {
                      if (youtubeIsCompleted || !player) return;
                      
                      try {
                        const currentTime = player.getCurrentTime();
                        const duration = player.getDuration();
                        
                        if (duration > 0) {
                          // Update max watched time
                          if (currentTime > youtubeMaxWatchedTime) {
                            youtubeMaxWatchedTime = currentTime;
                          }
                          
                          // Calculate progress percentage
                          const progress = (youtubeMaxWatchedTime / duration) * 100;
                          const progressElement = document.getElementById('progressPercent');
                          if (progressElement) {
                            progressElement.textContent = Math.round(progress) + '%';
                          }
                          
                          // Check if reached 85%
                          if (progress >= (COMPLETION_THRESHOLD * 100) && !youtubeIsCompleted) {
                            youtubeIsCompleted = true;
                            completeLesson();
                          }
                          
                          // Detect fast seeking (jump > 30 seconds)
                          const timeJump = Math.abs(currentTime - youtubeLastTime);
                          if (timeJump > 30 && !youtubeIsCompleted) {
                            showSeekWarning();
                          }
                          
                          youtubeLastTime = currentTime;
                        }
                      } catch (e) {
                        console.error('Error tracking YouTube progress:', e);
                      }
                    }, 1000); // Check every second
                  },
                  'onStateChange': function(event) {
                    console.log('YouTube player state:', event.data);
                    // State 0 = YT.PlayerState.ENDED
                    if (event.data === YT.PlayerState.ENDED && !youtubeIsCompleted) {
                      console.log('Video ended, marking as complete');
                      youtubeIsCompleted = true;
                      completeLesson();
                    }
                  }
                }
              });
            } catch (error) {
              console.error('Error initializing YouTube player:', error);
              // Fallback: Use interval to check video progress
              startProgressCheck();
            }
          }, 500);
        } catch (error) {
          console.error('Error setting up YouTube player:', error);
          startProgressCheck();
        }
      }

      // Fallback method: Check video progress periodically
      function startProgressCheck() {
        const checkInterval = setInterval(function() {
          if (youtubeIsCompleted) {
            clearInterval(checkInterval);
            return;
          }
          
          try {
            if (player && typeof player.getCurrentTime === 'function' && typeof player.getDuration === 'function') {
              const currentTime = player.getCurrentTime();
              const duration = player.getDuration();
              
              if (duration > 0) {
                // Update max watched time
                if (currentTime > youtubeMaxWatchedTime) {
                  youtubeMaxWatchedTime = currentTime;
                }
                
                // Calculate progress percentage
                const progress = (youtubeMaxWatchedTime / duration) * 100;
                const progressElement = document.getElementById('progressPercent');
                if (progressElement) {
                  progressElement.textContent = Math.round(progress) + '%';
                }
                
                // Check if reached 85%
                if (progress >= (COMPLETION_THRESHOLD * 100) && !youtubeIsCompleted) {
                  console.log('Video reached 85%, marking as complete');
                  youtubeIsCompleted = true;
                  clearInterval(checkInterval);
                  completeLesson();
                }
                
                // Detect fast seeking
                const timeJump = Math.abs(currentTime - youtubeLastTime);
                if (timeJump > 30 && !youtubeIsCompleted) {
                  showSeekWarning();
                }
                
                youtubeLastTime = currentTime;
              }
            }
          } catch (e) {
            // Player not ready yet
          }
        }, 1000); // Check every second
      }
    }
  }

  // Section collapse/expand functionality
  function initSectionToggles() {
    document.querySelectorAll('.lesson-sidebar__section-toggle').forEach(toggle => {
      toggle.addEventListener('click', function() {
        const section = this.closest('.lesson-sidebar__section');
        const lessons = section.querySelector('.lesson-sidebar__lessons');
        const icon = this.querySelector('i');
        
        if (lessons) {
          const isExpanded = !lessons.classList.contains('lesson-sidebar__lessons--collapsed');
          
          if (isExpanded) {
            lessons.classList.add('lesson-sidebar__lessons--collapsed');
            icon.classList.remove('fa-chevron-down');
            icon.classList.add('fa-chevron-right');
          } else {
            lessons.classList.remove('lesson-sidebar__lessons--collapsed');
            icon.classList.remove('fa-chevron-right');
            icon.classList.add('fa-chevron-down');
          }
        }
      });
    });
  }

  // Initialize section toggles on page load
  initSectionToggles();
});
</script>
@endsection
