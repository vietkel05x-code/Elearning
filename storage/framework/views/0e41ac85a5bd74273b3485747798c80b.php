

<?php $__env->startSection('title', 'Thống kê người học'); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/admin/admin.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<section class="admin-statistics-page">
  <h1 class="admin-statistics-page__title">Thống kê người học</h1>

  <!-- Summary Cards -->
  <div class="admin-summary-cards">
    <div class="admin-summary-card">
      <p class="admin-summary-card__label">Tổng học viên</p>
      <p class="admin-summary-card__value admin-summary-card__value--primary"><?php echo e($totalStudents); ?></p>
      <p class="admin-summary-card__meta"><?php echo e($activeStudents); ?> đang hoạt động</p>
    </div>
    <div class="admin-summary-card">
      <p class="admin-summary-card__label">Học viên mới (30 ngày)</p>
      <p class="admin-summary-card__value admin-summary-card__value--success"><?php echo e($newStudents); ?></p>
    </div>
    <div class="admin-summary-card">
      <p class="admin-summary-card__label">Tỉ lệ ghi danh</p>
      <p class="admin-summary-card__value admin-summary-card__value--info"><?php echo e($enrollmentRate); ?>%</p>
      <p class="admin-summary-card__meta"><?php echo e($studentsWithEnrollments); ?> / <?php echo e($totalStudents); ?> học viên</p>
    </div>
    <div class="admin-summary-card">
      <p class="admin-summary-card__label">Học viên có tiến độ</p>
      <p class="admin-summary-card__value admin-summary-card__value--warning"><?php echo e($studentsWithProgress); ?></p>
    </div>
  </div>

  <!-- Top Students by Enrollment -->
  <div class="admin-card">
    <h2 class="admin-card__title admin-mb--lg">Học viên có nhiều khóa học nhất</h2>
    <?php if($studentsByEnrollment->count() > 0): ?>
      <div style="overflow-x: auto;">
        <table class="admin-table">
          <thead>
            <tr>
              <th>Học viên</th>
              <th>Email</th>
              <th class="admin-table__cell--center">Số khóa học</th>
              <th>Ngày tham gia</th>
            </tr>
          </thead>
          <tbody>
            <?php $__currentLoopData = $studentsByEnrollment; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <tr>
                <td class="admin-table__cell--bold"><?php echo e($student->name); ?></td>
                <td><?php echo e($student->email); ?></td>
                <td class="admin-table__cell--center admin-table__cell--primary admin-table__cell--bold"><?php echo e($student->enrollments_count); ?></td>
                <td class="admin-table__cell--secondary"><?php echo e($student->created_at->format('d/m/Y')); ?></td>
              </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </tbody>
        </table>
      </div>
    <?php else: ?>
      <p class="admin-card__empty">Chưa có dữ liệu</p>
    <?php endif; ?>
  </div>

  <!-- Completion Statistics -->
  <?php if(count($completionData) > 0): ?>
    <div class="admin-card">
      <h2 class="admin-card__title admin-mb--lg">Top học viên theo tỉ lệ hoàn thành</h2>
      <div style="overflow-x: auto;">
        <table class="admin-table">
          <thead>
            <tr>
              <th>Học viên</th>
              <th>Email</th>
              <th class="admin-table__cell--center">Số khóa học</th>
              <th class="admin-table__cell--center">Bài học đã hoàn thành</th>
              <th class="admin-table__cell--center">Tổng bài học</th>
              <th class="admin-table__cell--center">Tỉ lệ hoàn thành</th>
            </tr>
          </thead>
          <tbody>
            <?php $__currentLoopData = $completionData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <tr>
                <td class="admin-table__cell--bold"><?php echo e($data['student']->name); ?></td>
                <td><?php echo e($data['student']->email); ?></td>
                <td class="admin-table__cell--center"><?php echo e($data['enrollments']); ?></td>
                <td class="admin-table__cell--center admin-table__cell--bold" style="color: var(--color-success);"><?php echo e($data['completed_lessons']); ?></td>
                <td class="admin-table__cell--center"><?php echo e($data['total_lessons']); ?></td>
                <td class="admin-table__cell--center">
                  <div class="admin-flex admin-flex--center-items admin-flex--center admin-flex--gap-sm">
                    <div style="flex: 1; max-width: 200px; height: 8px; background: #e9ecef; border-radius: var(--radius-sm); overflow: hidden;">
                      <div style="height: 100%; background: var(--color-success); width: <?php echo e($data['completion_rate']); ?>%;"></div>
                    </div>
                    <span class="admin-table__cell--bold" style="min-width: 50px;"><?php echo e($data['completion_rate']); ?>%</span>
                  </div>
                </td>
              </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </tbody>
        </table>
      </div>
    </div>
  <?php endif; ?>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\elearning\resources\views/admin/statistics/students.blade.php ENDPATH**/ ?>