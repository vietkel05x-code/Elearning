

<?php $__env->startSection('title', 'Thông tin cá nhân'); ?>
<?php $__env->startSection('page-title', 'Thông tin cá nhân'); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/admin/admin.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="admin-profile-page">
  <div class="admin-profile-grid">
    <!-- Avatar Section -->
    <div class="admin-profile-avatar-section">
      <?php
        $adminUser = \App\Helpers\AdminHelper::user();
      ?>
      <div class="admin-profile-avatar">
        <?php if($adminUser && $adminUser->avatar): ?>
          <img src="<?php echo e($adminUser->avatar_url); ?>" alt="Avatar">
        <?php else: ?>
          <span><?php echo e($adminUser ? strtoupper(substr($adminUser->name, 0, 1)) : 'A'); ?></span>
        <?php endif; ?>
      </div>
      <a href="<?php echo e(route('admin.profile.edit')); ?>" class="btn btn--primary admin-flex admin-flex--center">
        <i class="fas fa-edit"></i>
        <span>Chỉnh sửa thông tin</span>
      </a>
    </div>

    <!-- Info Section -->
    <div class="admin-profile-info">
      <h2 class="admin-profile-info__title">Thông tin tài khoản</h2>
      
      <div class="admin-profile-info__list">
        <div class="admin-profile-info__item">
          <p class="admin-profile-info__label">Họ và tên</p>
          <p class="admin-profile-info__value"><?php echo e($adminUser ? $adminUser->name : 'Admin'); ?></p>
        </div>

        <div class="admin-profile-info__item">
          <p class="admin-profile-info__label">Email</p>
          <p class="admin-profile-info__value admin-profile-info__value--secondary"><?php echo e($adminUser ? $adminUser->email : ''); ?></p>
        </div>

        <div class="admin-profile-info__item">
          <p class="admin-profile-info__label">Vai trò</p>
          <span class="admin-profile-badge">
            <i class="fas fa-shield-alt" style="margin-right: var(--spacing-xs);"></i>
            Administrator
          </span>
        </div>

        <div class="admin-profile-info__item admin-profile-info__item--last">
          <p class="admin-profile-info__label">Ngày tham gia</p>
          <p class="admin-profile-info__value admin-profile-info__value--secondary">
            <i class="far fa-calendar" style="margin-right: var(--spacing-xs); color: #9ca3af;"></i>
            <?php echo e($adminUser ? $adminUser->created_at->format('d/m/Y') : ''); ?>

          </p>
        </div>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\elearning\resources\views/admin/profile/show.blade.php ENDPATH**/ ?>