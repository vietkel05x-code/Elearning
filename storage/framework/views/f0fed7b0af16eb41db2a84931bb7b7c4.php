

<?php $__env->startSection('title', 'Danh sách khóa học'); ?>
<?php $__env->startSection('page-title', 'Quản lý khóa học'); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/admin/admin.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="admin-page">
  <div class="admin-page-header">
    <h2 class="admin-page-header__title">Danh sách khóa học</h2>
    <a href="<?php echo e(route('admin.courses.create')); ?>" class="admin-page-header__action">
      + Tạo khóa học mới
    </a>
  </div>

  <!-- Search and Filter -->
  <form method="GET" action="<?php echo e(route('admin.courses.index')); ?>" class="admin-filters">
    <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Tìm kiếm khóa học..." 
           class="admin-filters__search">
    
    <select name="category" class="admin-filters__select" onchange="this.form.submit()">
      <option value="">Tất cả danh mục</option>
      <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <option value="<?php echo e($cat->id); ?>" <?php echo e(request('category') == $cat->id ? 'selected' : ''); ?>>
          <?php echo e($cat->name); ?>

        </option>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
    
    <select name="status" class="admin-filters__select" onchange="this.form.submit()">
      <option value="">Tất cả trạng thái</option>
      <option value="published" <?php echo e(request('status') == 'published' ? 'selected' : ''); ?>>Đã xuất bản</option>
      <option value="draft" <?php echo e(request('status') == 'draft' ? 'selected' : ''); ?>>Bản nháp</option>
      <option value="hidden" <?php echo e(request('status') == 'hidden' ? 'selected' : ''); ?>>Ẩn</option>
      <option value="archived" <?php echo e(request('status') == 'archived' ? 'selected' : ''); ?>>Lưu trữ</option>
    </select>
    
    <button type="submit" class="admin-filters__button">Tìm kiếm</button>
    <?php if(request('search') || request('status') || request('category')): ?>
      <a href="<?php echo e(route('admin.courses.index')); ?>" class="admin-filters__clear">Xóa bộ lọc</a>
    <?php endif; ?>
  </form>

  <div class="admin-table-wrapper">
    <table class="admin-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Tiêu đề</th>
          <th>Danh mục</th>
          <th>Trạng thái</th>
          <th class="admin-table__cell--right">Giá</th>
          <th class="admin-table__cell--center">Hành động</th>
        </tr>
      </thead>
      <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <tr>
            <td><?php echo e($course->id); ?></td>
            <td>
              <a href="<?php echo e(route('admin.courses.edit', $course)); ?>" class="admin-table__link">
                <?php echo e($course->title); ?>

              </a>
              <div class="admin-table__slug"><?php echo e($course->slug); ?></div>
            </td>
            <td>
              <?php if($course->category): ?>
                <span class="admin-badge admin-badge--info"><?php echo e($course->category->name); ?></span>
              <?php else: ?>
                <span class="admin-table__muted">Chưa phân loại</span>
              <?php endif; ?>
            </td>
            <td>
              <span class="admin-badge admin-badge--<?php echo e($course->status); ?>">
                <?php if($course->status === 'published'): ?>
                  Đã xuất bản
                <?php elseif($course->status === 'draft'): ?>
                  Bản nháp
                <?php elseif($course->status === 'hidden'): ?>
                  Ẩn
                <?php else: ?>
                  <?php echo e(ucfirst($course->status)); ?>

                <?php endif; ?>
              </span>
            </td>
            <td class="admin-table__cell--right admin-table__cell--primary">
              ₫<?php echo e(number_format($course->price, 0, ',', '.')); ?>

            </td>
            <td class="admin-table__cell--center">
              <div class="admin-actions-container">
                <a href="<?php echo e(route('admin.courses.edit', $course)); ?>" class="btn btn--primary btn--sm">
                  Sửa
                </a>
                <a href="<?php echo e(route('courses.show', $course->slug)); ?>" target="_blank" class="btn btn--outline btn--sm">
                  Xem
                </a>
              </div>
            </td>
          </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <tr>
            <td colspan="6" class="admin-table__empty">
              Không tìm thấy khóa học nào
            </td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <!-- Pagination -->
  <div class="admin-pagination">
    <?php echo e($courses->links('vendor.pagination.custom')); ?>

  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\elearning\resources\views/admin/courses/index.blade.php ENDPATH**/ ?>