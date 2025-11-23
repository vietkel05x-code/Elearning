

<?php $__env->startSection('title', 'Thống kê khóa học'); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/admin/admin.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<section class="admin-statistics-page">
  <h1 class="admin-statistics-page__title">Thống kê khóa học</h1>

  <!-- Summary Cards -->
  <div class="admin-summary-cards">
    <div class="admin-summary-card">
      <p class="admin-summary-card__label">Tổng khóa học</p>
      <p class="admin-summary-card__value admin-summary-card__value--primary"><?php echo e($totalCourses); ?></p>
      <p class="admin-summary-card__meta"><?php echo e($publishedCourses); ?> đã xuất bản</p>
    </div>
    <div class="admin-summary-card">
      <p class="admin-summary-card__label">Tổng lượt ghi danh</p>
      <p class="admin-summary-card__value admin-summary-card__value--success"><?php echo e($totalEnrollments); ?></p>
      <p class="admin-summary-card__meta">Trung bình <?php echo e($avgEnrollmentsPerCourse); ?> / khóa học</p>
    </div>
    <div class="admin-summary-card">
      <p class="admin-summary-card__label">Khóa học đã xuất bản</p>
      <p class="admin-summary-card__value admin-summary-card__value--info"><?php echo e($publishedCourses); ?></p>
      <p class="admin-summary-card__meta"><?php echo e($draftCourses); ?> bản nháp</p>
    </div>
  </div>

  <!-- Top Courses by Enrollment -->
  <div class="admin-card">
    <h2 class="admin-card__title admin-mb--lg">Top khóa học theo lượt ghi danh</h2>
    <?php if($topCoursesByEnrollment->count() > 0): ?>
      <div style="overflow-x: auto;">
        <table class="admin-table">
          <thead>
            <tr>
              <th>Khóa học</th>
              <th>Danh mục</th>
              <th>Giảng viên</th>
              <th class="admin-table__cell--center">Lượt ghi danh</th>
              <th class="admin-table__cell--center">Đánh giá</th>
              <th class="admin-table__cell--right">Giá</th>
            </tr>
          </thead>
          <tbody>
            <?php $__currentLoopData = $topCoursesByEnrollment; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <tr>
                <td class="admin-table__cell--bold"><?php echo e($course->title); ?></td>
                <td><?php echo e($course->category->name ?? '-'); ?></td>
                <td><?php echo e($course->instructor->name ?? '-'); ?></td>
                <td class="admin-table__cell--center admin-table__cell--bold"><?php echo e($course->enrolled_students); ?></td>
                <td class="admin-table__cell--center">
                  <?php if($course->rating > 0): ?>
                    <?php echo e(number_format($course->rating, 1)); ?> ⭐ (<?php echo e($course->rating_count ?? 0); ?> đánh giá)
                  <?php else: ?>
                    Chưa có đánh giá
                  <?php endif; ?>
                </td>
                <td class="admin-table__cell--right admin-table__cell--bold">₫<?php echo e(number_format($course->price, 0, ',', '.')); ?></td>
              </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </tbody>
        </table>
      </div>
    <?php else: ?>
      <p class="admin-card__empty">Chưa có khóa học nào</p>
    <?php endif; ?>
  </div>

  <!-- Top Courses by Rating -->
  <div class="admin-card">
    <h2 class="admin-card__title admin-mb--lg">Top khóa học theo đánh giá</h2>
    <?php if($topCoursesByRating->count() > 0): ?>
      <div style="overflow-x: auto;">
        <table class="admin-table">
          <thead>
            <tr>
              <th>Khóa học</th>
              <th>Danh mục</th>
              <th class="admin-table__cell--center">Đánh giá</th>
              <th class="admin-table__cell--center">Số đánh giá</th>
              <th class="admin-table__cell--center">Lượt ghi danh</th>
            </tr>
          </thead>
          <tbody>
            <?php $__currentLoopData = $topCoursesByRating; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <tr>
                <td class="admin-table__cell--bold"><?php echo e($course->title); ?></td>
                <td><?php echo e($course->category->name ?? '-'); ?></td>
                <td class="admin-table__cell--center admin-table__cell--bold" style="font-size: var(--font-size-lg);">
                  <?php echo e(number_format($course->rating, 1)); ?> ⭐
                </td>
                <td class="admin-table__cell--center"><?php echo e($course->rating_count ?? 0); ?></td>
                <td class="admin-table__cell--center"><?php echo e($course->enrolled_students); ?></td>
              </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </tbody>
        </table>
      </div>
    <?php else: ?>
      <p class="admin-card__empty">Chưa có khóa học nào có đánh giá</p>
    <?php endif; ?>
  </div>

  <!-- Courses by Category -->
  <div class="admin-card">
    <h2 class="admin-card__title admin-mb--lg">Phân bố khóa học theo danh mục</h2>
    <?php if($coursesByCategory->count() > 0): ?>
      <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: var(--spacing-md);">
        <?php $__currentLoopData = $coursesByCategory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div style="padding: var(--spacing-md); background: var(--color-bg-light); border-radius: var(--radius-md);">
            <p style="margin: 0; font-weight: bold; font-size: var(--font-size-md);"><?php echo e($item->category->name ?? 'Chưa phân loại'); ?></p>
            <p style="margin: var(--spacing-sm) 0 0 0; font-size: var(--font-size-2xl); color: var(--color-primary); font-weight: bold;"><?php echo e($item->count); ?> khóa học</p>
          </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
    <?php else: ?>
      <p class="admin-card__empty">Chưa có dữ liệu</p>
    <?php endif; ?>
  </div>

  <!-- Completion Statistics -->
  <?php if(count($completionStats) > 0): ?>
    <div class="admin-card">
      <h2 class="admin-card__title admin-mb--lg">Tỉ lệ hoàn thành khóa học</h2>
      <div style="overflow-x: auto;">
        <table class="admin-table">
          <thead>
            <tr>
              <th>Khóa học</th>
              <th class="admin-table__cell--center">Lượt ghi danh</th>
              <th class="admin-table__cell--center">Tỉ lệ hoàn thành</th>
              <th class="admin-table__cell--center">Thanh toán</th>
            </tr>
          </thead>
          <tbody>
            <?php $__currentLoopData = $completionStats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <tr>
                <td class="admin-table__cell--bold"><?php echo e($stat['course']->title); ?></td>
                <td class="admin-table__cell--center"><?php echo e($stat['enrollments']); ?></td>
                <td class="admin-table__cell--center">
                  <div class="admin-flex admin-flex--center-items admin-flex--center admin-flex--gap-sm">
                    <div style="flex: 1; max-width: 200px; height: 8px; background: #e9ecef; border-radius: var(--radius-sm); overflow: hidden;">
                      <div style="height: 100%; background: var(--color-success); width: <?php echo e($stat['completion_rate']); ?>%;"></div>
                    </div>
                    <span class="admin-table__cell--bold" style="min-width: 50px;"><?php echo e($stat['completion_rate']); ?>%</span>
                  </div>
                </td>
                <td class="admin-table__cell--center">₫<?php echo e(number_format($stat['course']->price, 0, ',', '.')); ?></td>
              </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </tbody>
        </table>
      </div>
    </div>
  <?php endif; ?>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\elearning\resources\views/admin/statistics/courses.blade.php ENDPATH**/ ?>