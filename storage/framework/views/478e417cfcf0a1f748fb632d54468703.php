

<?php $__env->startSection('title', 'Đơn hàng của tôi'); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/pages/orders.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<section class="orders-page">
  <h1 class="orders-page__title">Đơn hàng của tôi</h1>

  <?php if($orders->count() > 0): ?>
    <div class="orders-list">
      <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="order-card">
          <div class="order-card__header">
            <div class="order-card__info">
              <h3 class="order-card__title">
                <a href="<?php echo e(route('orders.show', $order)); ?>" class="order-card__title-link">
                  Đơn hàng #<?php echo e($order->code); ?>

                </a>
              </h3>
              <p class="order-card__date">
                <?php echo e($order->created_at->format('d/m/Y H:i')); ?>

              </p>
            </div>
            <div class="order-card__status">
              <span class="order-card__status-badge order-card__status-badge--<?php echo e($order->status); ?>">
                <?php echo e(ucfirst($order->status)); ?>

              </span>
              <p class="order-card__total">
                ₫<?php echo e(number_format($order->total, 0, ',', '.')); ?>

              </p>
            </div>
          </div>

          <a href="<?php echo e(route('orders.show', $order)); ?>" class="order-card__link">
            Xem chi tiết →
          </a>
        </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <div style="margin-top: var(--spacing-xl);">
      <?php echo e($orders->links()); ?>

    </div>
  <?php else: ?>
    <div class="orders-empty">
      <p class="orders-empty__message">Bạn chưa có đơn hàng nào</p>
      <a href="<?php echo e(route('home')); ?>" class="btn btn--primary">
        Khám phá khóa học
      </a>
    </div>
  <?php endif; ?>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\elearning\resources\views/orders/index.blade.php ENDPATH**/ ?>