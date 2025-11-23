<h2 class="lesson-sidebar__title">Nội dung khóa học</h2>

<!-- Course Progress -->
<div class="lesson-sidebar__progress">
  <div class="lesson-sidebar__progress-header">
    <span class="lesson-sidebar__progress-label">Tiến độ khóa học</span>
    <span class="lesson-sidebar__progress-percent"><?php echo e($courseProgress); ?>%</span>
  </div>
  <div class="lesson-sidebar__progress-bar">
    <div class="lesson-sidebar__progress-fill" style="width: <?php echo e($courseProgress); ?>%"></div>
  </div>
  <div class="lesson-sidebar__progress-text">
    <?php echo e($completedLessons); ?> / <?php echo e($totalLessons); ?> bài học đã hoàn thành
  </div>
</div>

<div class="lesson-sidebar__sections">
  <?php $__currentLoopData = $course->sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="lesson-sidebar__section" data-section-id="<?php echo e($section->id); ?>">
      <div class="lesson-sidebar__section-header">
        <h3 class="lesson-sidebar__section-title"><?php echo e($section->title); ?></h3>
        <button class="lesson-sidebar__section-toggle" type="button" aria-label="Thu gọn/mở rộng">
          <i class="fas fa-chevron-down"></i>
        </button>
      </div>
      <div class="lesson-sidebar__lessons">
        <?php $__currentLoopData = $section->lessons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $l): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <?php
            $isLockedLesson = isset($lockedLessons[$l->id]);
            $isCompleted = isset($progress[$l->id]);
            $isCurrent = isset($currentLessonId) && $l->id == $currentLessonId;
          ?>
          <?php if($isLockedLesson && !$isCurrent): ?>
            <div class="lesson-item lesson-item--locked">
              <span class="lesson-item__icon lesson-item__icon--normal">🔒</span>
              <span class="lesson-item__title"><?php echo e($l->title); ?></span>
            </div>
          <?php else: ?>
            <a href="<?php echo e(route('student.lesson', ['course' => $course->slug, 'lesson' => $l->id])); ?>" 
               class="lesson-item <?php echo e($isCurrent ? 'lesson-item--current' : ($isCompleted ? 'lesson-item--completed' : 'lesson-item--normal')); ?>">
              <span class="lesson-item__icon <?php echo e($isCompleted ? 'lesson-item__icon--completed' : ($isCurrent ? 'lesson-item__icon--current' : 'lesson-item__icon--normal')); ?>">
                <?php if($isCompleted): ?>
                  <span>✓</span>
                <?php else: ?>
                  <span><?php echo e($loop->iteration); ?></span>
                <?php endif; ?>
              </span>
              <span class="lesson-item__title"><?php echo e($l->title); ?></span>
              <?php if($l->is_preview): ?>
                <span class="lesson-item__badge lesson-item__badge--preview">Preview</span>
              <?php endif; ?>
            </a>
          <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
    </div>
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<?php /**PATH D:\elearning\resources\views/student/partials/sidebar.blade.php ENDPATH**/ ?>