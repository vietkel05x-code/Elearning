

<?php $__env->startSection('title', 'Quản lý thông báo'); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/admin/admin.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<section class="admin-page">
  <div class="admin-page-header">
    <h1 class="admin-page-header__title">Quản lý thông báo</h1>
    <a href="<?php echo e(route('admin.notifications.create')); ?>" class="admin-page-header__action">
      + Gửi thông báo mới
    </a>
  </div>

  <?php if(session('success')): ?>
    <div class="alert alert--success"><?php echo e(session('success')); ?></div>
  <?php endif; ?>

  <?php if($notifications->count() > 0): ?>
    <div class="admin-table-wrapper">
      <table class="admin-table">
        <thead>
          <tr>
            <th>Tiêu đề</th>
            <th>Người gửi</th>
            <th class="admin-table__cell--center">Người nhận</th>
            <th>Ngày gửi</th>
            <th class="admin-table__cell--center">Hành động</th>
          </tr>
        </thead>
        <tbody>
          <?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
              <td class="admin-table__cell--bold"><?php echo e($notification->title); ?></td>
              <td><?php echo e($notification->creator->name ?? 'System'); ?></td>
              <td class="admin-table__cell--center">
                <span class="admin-badge admin-badge--info">
                  <?php echo e($notification->users->count()); ?> người
                </span>
              </td>
              <td class="admin-table__cell--secondary">
                <?php echo e($notification->created_at->format('d/m/Y H:i')); ?>

              </td>
              <td class="admin-table__cell--center">
                <div class="admin-actions-container">
                  <a href="<?php echo e(route('admin.notifications.show', $notification)); ?>" class="btn btn--outline btn--sm">
                    Xem
                  </a>
                  <form action="<?php echo e(route('admin.notifications.destroy', $notification)); ?>" method="POST" class="admin-actions-container--inline">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" onclick="return confirm('Bạn có chắc muốn xóa thông báo này?')" 
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

    <div class="admin-pagination">
      <?php echo e($notifications->links()); ?>

    </div>
  <?php else: ?>
    <div class="admin-card card">
      <p class="admin-empty-state admin-empty-state--with-margin">
        Chưa có thông báo nào
      </p>
      <div class="admin-flex admin-flex--center">
        <a href="<?php echo e(route('admin.notifications.create')); ?>" class="btn btn--primary">
          Gửi thông báo đầu tiên
        </a>
      </div>
    </div>
  <?php endif; ?>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\elearning\resources\views/admin/notifications/index.blade.php ENDPATH**/ ?>