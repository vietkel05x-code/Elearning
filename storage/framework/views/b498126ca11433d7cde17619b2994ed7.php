

<?php $__env->startSection('title', 'Quản lý danh mục'); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/admin/admin.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<section class="admin-page">
  <div class="admin-page-header">
    <h1 class="admin-page-header__title">Quản lý danh mục</h1>
    <a href="<?php echo e(route('admin.categories.create')); ?>" class="admin-page-header__action">
      + Thêm danh mục
    </a>
  </div>

  <?php if(session('success')): ?>
    <div class="alert alert--success"><?php echo e(session('success')); ?></div>
  <?php endif; ?>

  <?php if(session('error')): ?>
    <div class="alert alert--error"><?php echo e(session('error')); ?></div>
  <?php endif; ?>

  <div class="admin-table-wrapper">
    <table class="admin-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Tên</th>
          <th>Slug</th>
          <th>Danh mục cha</th>
          <th class="admin-table__cell--center">Khóa học</th>
          <th class="admin-table__cell--center">Hành động</th>
        </tr>
      </thead>
      <tbody>
        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <tr>
            <td><?php echo e($category->id); ?></td>
            <td class="admin-table__cell--bold"><?php echo e($category->name); ?></td>
            <td class="admin-table__cell--secondary"><?php echo e($category->slug); ?></td>
            <td>
              <?php if($category->parent): ?>
                <span class="admin-text--secondary"><?php echo e($category->parent->name); ?></span>
              <?php else: ?>
                <span class="admin-text--muted">-</span>
              <?php endif; ?>
            </td>
            <td class="admin-table__cell--center">
              <span class="admin-badge admin-badge--info">
                <?php echo e($category->courses()->count()); ?>

              </span>
            </td>
            <td class="admin-table__cell--center">
              <div class="admin-actions-container">
                <a href="<?php echo e(route('admin.categories.edit', $category)); ?>" class="btn btn--outline btn--sm">
                  Sửa
                </a>
                <form action="<?php echo e(route('admin.categories.destroy', $category)); ?>" method="POST" class="admin-actions-container--inline">
                  <?php echo csrf_field(); ?>
                  <?php echo method_field('DELETE'); ?>
                  <button type="submit" onclick="return confirm('Bạn có chắc muốn xóa danh mục này?')" 
                          class="btn btn--danger btn--sm">
                    Xóa
                  </button>
                </form>
              </div>
            </td>
          </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </tbody>
    </table>
  </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\elearning\resources\views/admin/categories/index.blade.php ENDPATH**/ ?>