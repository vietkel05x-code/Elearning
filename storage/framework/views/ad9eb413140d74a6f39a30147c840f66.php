

<?php $__env->startSection('title', 'Quản lý đánh giá'); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/admin/admin.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<section class="admin-page">
  <div class="admin-page-header">
    <h1 class="admin-page-header__title">Quản lý đánh giá</h1>
  </div>

  <?php if(session('success')): ?>
    <div class="alert alert--success"><?php echo e(session('success')); ?></div>
  <?php endif; ?>

  <!-- Filters -->
  <form method="GET" action="<?php echo e(route('admin.reviews.index')); ?>" class="admin-filters card admin-mb--lg">
    <div class="admin-form__grid admin-form__grid--auto">
      <div>
        <label class="admin-form__label">Tìm kiếm</label>
        <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Tên, email, khóa học..." 
               class="admin-form__input">
      </div>
      <div>
        <label class="admin-form__label">Khóa học</label>
        <select name="course_id" class="admin-form__select">
          <option value="">Tất cả</option>
          <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($course->id); ?>" <?php echo e(request('course_id') == $course->id ? 'selected' : ''); ?>>
              <?php echo e($course->title); ?>

            </option>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
      </div>
      <div>
        <label class="admin-form__label">Đánh giá</label>
        <select name="rating" class="admin-form__select">
          <option value="">Tất cả</option>
          <?php for($i = 5; $i >= 1; $i--): ?>
            <option value="<?php echo e($i); ?>" <?php echo e(request('rating') == $i ? 'selected' : ''); ?>>
              <?php echo e($i); ?> sao
            </option>
          <?php endfor; ?>
        </select>
      </div>
      <div class="admin-flex admin-flex--center-items" style="align-items: flex-end; gap: var(--spacing-sm);">
        <button type="submit" class="btn btn--primary">Lọc</button>
        <a href="<?php echo e(route('admin.reviews.index')); ?>" class="btn btn--outline">Reset</a>
      </div>
    </div>
  </form>

  <!-- Reviews Table -->
  <?php if($reviews->count() > 0): ?>
    <div class="admin-table-wrapper">
      <table class="admin-table">
        <thead>
          <tr>
            <th>Người dùng</th>
            <th>Khóa học</th>
            <th class="admin-table__cell--center">Đánh giá</th>
            <th>Nội dung</th>
            <th>Ngày</th>
            <th class="admin-table__cell--center">Hành động</th>
          </tr>
        </thead>
        <tbody>
          <?php $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
              <td>
                <div class="admin-text--bold"><?php echo e($review->user->name); ?></div>
                <div class="admin-text--small admin-text--secondary"><?php echo e($review->user->email); ?></div>
              </td>
              <td>
                <a href="<?php echo e(route('courses.show', $review->course->slug)); ?>" target="_blank" class="admin-table__link">
                  <?php echo e($review->course->title); ?>

                </a>
              </td>
              <td class="admin-table__cell--center">
                <div class="admin-flex admin-flex--center-items admin-flex--center admin-flex--gap-sm">
                  <?php for($i = 1; $i <= 5; $i++): ?>
                    <i class="fa fa-star<?php echo e($i <= $review->rating ? '' : '-o'); ?>" style="color: #f3ca8c;"></i>
                  <?php endfor; ?>
                </div>
              </td>
              <td style="max-width: 300px;">
                <p class="admin-text--secondary" style="margin: 0;">
                  <?php echo e(Str::limit($review->content ?? 'Không có nhận xét', 100)); ?>

                </p>
              </td>
              <td class="admin-table__cell--secondary">
                <?php echo e($review->created_at->format('d/m/Y H:i')); ?>

              </td>
              <td class="admin-table__cell--center">
                <form action="<?php echo e(route('admin.reviews.destroy', $review)); ?>" method="POST" class="admin-actions-container--inline">
                  <?php echo csrf_field(); ?>
                  <?php echo method_field('DELETE'); ?>
                  <button type="submit" onclick="return confirm('Bạn có chắc muốn xóa đánh giá này?')" 
                          class="btn btn--danger btn--sm">
                    Xóa
                  </button>
                </form>
              </td>
            </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
      </table>
    </div>

    <div class="admin-pagination">
      <?php echo e($reviews->links()); ?>

    </div>
  <?php else: ?>
    <div class="admin-card card">
      <p class="admin-empty-state">
        Không tìm thấy đánh giá nào
      </p>
    </div>
  <?php endif; ?>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\elearning\resources\views/admin/reviews/index.blade.php ENDPATH**/ ?>