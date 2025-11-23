<?php $__env->startSection('title', $course->title); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/pages/student-learn.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<section class="learn-page">
  <div class="learn-grid">
    <!-- Sidebar: Course Content -->
    <aside class="learn-sidebar">
      <?php
        // Calculate course progress
        $totalLessons = $course->sections->sum(function($s) {
          return $s->lessons->count();
        });
        $completedLessons = count($progress);
        $courseProgress = $totalLessons > 0 ? round(($completedLessons / $totalLessons) * 100) : 0;
      ?>
      
      <h2 class="learn-sidebar__title">Nội dung khóa học</h2>
      
      <!-- Q&A Button -->
      <a href="<?php echo e(route('questions.index', $course)); ?>" class="learn-sidebar__qa-btn" style="display: block; margin-bottom: 16px; padding: 10px; background: #f7f9fa; border: 1px solid #d1d7dc; border-radius: 4px; text-align: center; color: #1c1d1f; text-decoration: none; font-weight: 500;">
        <i class="fas fa-comments"></i> Hỏi đáp (Q&A)
      </a>
      
      <!-- Course Progress -->
      <div class="learn-sidebar__progress">
        <div class="learn-sidebar__progress-header">
          <span class="learn-sidebar__progress-label">Tiến độ khóa học</span>
          <span class="learn-sidebar__progress-percent"><?php echo e($courseProgress); ?>%</span>
        </div>
        <div class="learn-sidebar__progress-bar">
          <div class="learn-sidebar__progress-fill" style="width: <?php echo e($courseProgress); ?>%"></div>
        </div>
        <div class="learn-sidebar__progress-text">
          <?php echo e($completedLessons); ?> / <?php echo e($totalLessons); ?> bài học đã hoàn thành
        </div>
      </div>
      
      <div class="learn-sidebar__sections">
        <?php $__currentLoopData = $course->sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div class="learn-sidebar__section" data-section-id="<?php echo e($section->id); ?>">
            <div class="learn-sidebar__section-header">
              <h3 class="learn-sidebar__section-title"><?php echo e($section->title); ?></h3>
              <button class="learn-sidebar__section-toggle" type="button" aria-label="Thu gọn/mở rộng">
                <i class="fas fa-chevron-down"></i>
              </button>
            </div>
            <div class="learn-sidebar__lessons">
              <?php $__currentLoopData = $section->lessons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lesson): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                  $isLocked = isset($lockedLessons[$lesson->id]);
                  $isCompleted = isset($progress[$lesson->id]);
                ?>
                <?php if($isLocked): ?>
                  <div class="lesson-item lesson-item--locked">
                    <span class="lesson-item__icon lesson-item__icon--normal">🔒</span>
                    <span class="lesson-item__title"><?php echo e($lesson->title); ?></span>
                    <span style="font-size:11px;color:#999">Khóa</span>
                  </div>
                <?php else: ?>
                  <a href="<?php echo e(route('student.lesson', ['course' => $course->slug, 'lesson' => $lesson->id])); ?>" 
                     class="lesson-item <?php echo e($isCompleted ? 'lesson-item--completed' : 'lesson-item--normal'); ?>">
                    <span class="lesson-item__icon <?php echo e($isCompleted ? 'lesson-item__icon--completed' : 'lesson-item__icon--normal'); ?>">
                      <?php if($isCompleted): ?>
                        <span>✓</span>
                      <?php else: ?>
                        <span><?php echo e($loop->iteration); ?></span>
                      <?php endif; ?>
                    </span>
                    <span class="lesson-item__title"><?php echo e($lesson->title); ?></span>
                    <?php if($lesson->is_preview): ?>
                      <span class="lesson-item__badge lesson-item__badge--preview">Preview</span>
                    <?php endif; ?>
                  </a>
                <?php endif; ?>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
          </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
    </aside>

    <!-- Main Content -->
    <main class="learn-main">
      <div class="learn-welcome card">
        <h1 class="learn-welcome__title"><?php echo e($course->title); ?></h1>
        <p class="learn-welcome__description"><?php echo e($course->short_description); ?></p>
        
        <?php if($course->sections->count() > 0): ?>
          <div class="learn-welcome__message">
            <p>Chọn một bài học từ menu bên trái để bắt đầu học</p>
          </div>
        <?php else: ?>
          <div class="learn-welcome__message learn-welcome__message--warning">
            <p>Khóa học này chưa có nội dung. Vui lòng quay lại sau.</p>
          </div>
        <?php endif; ?>
      </div>

      <!-- Course Info -->
      <div class="learn-info card">
        <h2 class="learn-info__title">Về khóa học</h2>
        <div class="learn-info__grid">
          <div>
            <p class="learn-info__item-label">Giảng viên</p>
            <p class="learn-info__item-value"><?php echo e($course->instructor->name ?? 'N/A'); ?></p>
          </div>
          <div>
            <p class="learn-info__item-label">Cấp độ</p>
            <p class="learn-info__item-value"><?php echo e(ucfirst($course->level ?? 'Beginner')); ?></p>
          </div>
          <div>
            <p class="learn-info__item-label">Ngôn ngữ</p>
            <p class="learn-info__item-value"><?php echo e($course->language ?? 'Vietnamese'); ?></p>
          </div>
          <div>
            <p class="learn-info__item-label">Thời lượng</p>
            <p class="learn-info__item-value"><?php echo e($course->formatted_total_duration); ?></p>
          </div>
        </div>

        <?php if($course->description_html): ?>
          <div class="learn-info__description">
            <?php echo $course->description_html; ?>

          </div>
        <?php endif; ?>
      </div>
    </main>
  </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
  // Section collapse/expand functionality
  document.querySelectorAll('.learn-sidebar__section-toggle').forEach(toggle => {
    toggle.addEventListener('click', function() {
      const section = this.closest('.learn-sidebar__section');
      const lessons = section.querySelector('.learn-sidebar__lessons');
      const icon = this.querySelector('i');
      
      if (lessons) {
        const isExpanded = !lessons.classList.contains('learn-sidebar__lessons--collapsed');
        
        if (isExpanded) {
          lessons.classList.add('learn-sidebar__lessons--collapsed');
          icon.classList.remove('fa-chevron-down');
          icon.classList.add('fa-chevron-right');
        } else {
          lessons.classList.remove('learn-sidebar__lessons--collapsed');
          icon.classList.remove('fa-chevron-right');
          icon.classList.add('fa-chevron-down');
        }
      }
    });
  });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\elearning\resources\views/student/learn.blade.php ENDPATH**/ ?>