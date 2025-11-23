

<?php $__env->startSection('title', 'Thông báo'); ?>

<?php $__env->startSection('content'); ?>
<section class="page-wrapper" style="max-width:900px;margin:40px auto;padding:0 20px">
  <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px">
    <h1>Thông báo của tôi</h1>
    <?php if(Auth::user()->unreadNotificationsCount() > 0): ?>
      <form action="<?php echo e(route('notifications.mark-all-read')); ?>" method="POST" style="display:inline">
        <?php echo csrf_field(); ?>
        <button type="submit" style="padding:10px 20px;background:#28a745;color:white;border:none;border-radius:8px;cursor:pointer;font-weight:bold">
          Đánh dấu tất cả đã đọc
        </button>
      </form>
    <?php endif; ?>
  </div>

  <?php if(session('success')): ?>
    <div style="background:#d4edda;color:#155724;padding:12px;border-radius:8px;margin-bottom:20px">
      <?php echo e(session('success')); ?>

    </div>
  <?php endif; ?>

  <?php if($notifications->count() > 0): ?>
    <div style="display:grid;gap:16px">
      <?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
          $isRead = $notification->pivot->read_at !== null;
        ?>
        <div style="border:1px solid #eee;border-radius:12px;padding:20px;background:#fff;<?php echo e(!$isRead ? 'border-left:4px solid #a435f0;' : ''); ?>">
          <div style="display:flex;justify-content:space-between;align-items:start;margin-bottom:12px">
            <div style="flex:1">
              <h3 style="margin:0 0 8px 0;font-size:18px;<?php echo e(!$isRead ? 'font-weight:bold;' : ''); ?>">
                <?php echo e($notification->title); ?>

              </h3>
              <p style="color:#666;margin:0;font-size:14px">
                <?php echo e($notification->created_at->format('d/m/Y H:i')); ?>

                <?php if($notification->creator): ?>
                  · Gửi bởi <?php echo e($notification->creator->name); ?>

                <?php endif; ?>
              </p>
            </div>
            <?php if(!$isRead): ?>
              <form action="<?php echo e(route('notifications.mark-read', $notification)); ?>" method="POST" style="display:inline">
                <?php echo csrf_field(); ?>
                <button type="submit" style="padding:6px 12px;background:#a435f0;color:white;border:none;border-radius:6px;cursor:pointer;font-size:12px">
                  Đánh dấu đã đọc
                </button>
              </form>
            <?php else: ?>
              <span style="padding:6px 12px;background:#d4edda;color:#155724;border-radius:6px;font-size:12px;font-weight:bold">
                ✓ Đã đọc
              </span>
            <?php endif; ?>
          </div>
          <div style="padding:12px;background:#f8f9fa;border-radius:8px">
            <p style="margin:0;line-height:1.6;white-space:pre-wrap"><?php echo e($notification->body); ?></p>
          </div>
        </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <div style="margin-top:32px">
      <?php echo e($notifications->links()); ?>

    </div>
  <?php else: ?>
    <div style="text-align:center;padding:60px 20px;background:#fff;border:1px solid #eee;border-radius:12px">
      <p style="font-size:18px;color:#666;margin-bottom:24px">Bạn chưa có thông báo nào</p>
    </div>
  <?php endif; ?>
</section>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\elearning\resources\views/notifications/index.blade.php ENDPATH**/ ?>