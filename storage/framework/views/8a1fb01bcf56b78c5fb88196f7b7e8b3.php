

<?php $__env->startSection('title', 'Chi tiết thông báo'); ?>
<?php $__env->startSection('page-title', 'Chi tiết thông báo'); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/admin/admin.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<section class="admin-page admin-max-w--900">
  <div class="admin-mb--lg">
    <a href="<?php echo e(route('admin.notifications.index')); ?>" class="admin-card__link">← Quay lại danh sách</a>
  </div>

  <div class="admin-card">
    <div class="admin-notification-header">
      <div>
        <h1 class="admin-notification-title"><?php echo e($notification->title); ?></h1>
        <p class="admin-notification-meta">
          Gửi bởi: <?php echo e($notification->creator->name ?? 'System'); ?> · 
          <?php echo e($notification->created_at->format('d/m/Y H:i')); ?>

        </p>
      </div>
      <form action="<?php echo e(route('admin.notifications.destroy', $notification)); ?>" method="POST" class="admin-actions-container--inline">
        <?php echo csrf_field(); ?>
        <?php echo method_field('DELETE'); ?>
        <button type="submit" onclick="return confirm('Bạn có chắc muốn xóa thông báo này?')" 
                class="btn btn--danger">
          Xóa
        </button>
      </form>
    </div>

    <div class="admin-notification-body">
      <p class="admin-notification-body__text"><?php echo e($notification->body); ?></p>
    </div>

    <div>
      <h3 class="admin-card__title" style="margin-bottom: var(--spacing-md);">Người nhận (<?php echo e($notification->users->count()); ?>)</h3>
      <div class="admin-notification-recipients">
        <?php $__currentLoopData = $notification->users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div class="admin-notification-recipient">
            <p class="admin-notification-recipient__name"><?php echo e($user->name); ?></p>
            <p class="admin-notification-recipient__email"><?php echo e($user->email); ?></p>
            <?php if($user->pivot->read_at): ?>
              <span class="admin-badge admin-badge--success admin-notification-recipient__badge">
                Đã đọc
              </span>
            <?php else: ?>
              <span class="admin-badge admin-badge--gray admin-notification-recipient__badge">
                Chưa đọc
              </span>
            <?php endif; ?>
          </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
    </div>
  </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\elearning\resources\views/admin/notifications/show.blade.php ENDPATH**/ ?>