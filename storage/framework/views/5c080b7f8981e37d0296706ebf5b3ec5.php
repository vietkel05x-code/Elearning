

<?php $__env->startSection('title', 'Chi tiết đơn hàng'); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/pages/orders.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<section class="order-detail-page">
  <div>
    <a href="<?php echo e(route('orders.index')); ?>" class="order-detail__back-link">← Quay lại danh sách đơn hàng</a>
  </div>

  <h1 class="order-detail__title">Đơn hàng #<?php echo e($order->code); ?></h1>

  <?php if(session('success')): ?>
    <div class="alert alert--success"><?php echo e(session('success')); ?></div>
  <?php endif; ?>

  <div class="order-detail__content">
    <!-- Order Info -->
    <div class="order-detail__card">
      <div class="order-detail__info-grid">
        <div>
          <p class="order-detail__info-label">Ngày đặt hàng</p>
          <p class="order-detail__info-value"><?php echo e($order->created_at->format('d/m/Y H:i')); ?></p>
        </div>
        <div>
          <p class="order-detail__info-label">Trạng thái</p>
          <span class="order-detail__status-badge order-detail__status-badge--<?php echo e($order->status); ?>">
            <?php if($order->status === 'paid'): ?>
              Đã thanh toán
            <?php elseif($order->status === 'pending'): ?>
              Chờ thanh toán
            <?php elseif($order->status === 'failed'): ?>
              Thanh toán thất bại
            <?php else: ?>
              <?php echo e(ucfirst($order->status)); ?>

            <?php endif; ?>
          </span>
        </div>
      </div>

      <hr class="order-detail__divider">

      <h3 class="order-detail__items-title">Khóa học đã mua</h3>
      <div class="order-detail__items-list">
        <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div class="order-detail__item">
            <img src="<?php echo e($item->course->thumbnail_url); ?>" alt="<?php echo e($item->course->title); ?>" 
                 class="order-detail__item-image">
            <div class="order-detail__item-content">
              <h4 class="order-detail__item-title">
                <a href="<?php echo e(route('courses.show', $item->course->slug)); ?>" class="order-detail__item-title-link">
                  <?php echo e($item->course->title); ?>

                </a>
              </h4>
              <p class="order-detail__item-instructor"><?php echo e($item->course->instructor->name ?? 'Instructor'); ?></p>
              <div class="order-detail__item-footer">
                <span class="order-detail__item-price">
                  ₫<?php echo e(number_format($item->price, 0, ',', '.')); ?>

                </span>
                <?php if($order->status === 'paid'): ?>
                  <a href="<?php echo e(route('student.learn', $item->course->slug)); ?>" class="btn btn--success btn--sm">
                    Bắt đầu học
                  </a>
                <?php endif; ?>
              </div>
            </div>
          </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
    </div>

    <!-- Payment Summary -->
    <div class="order-detail__card">
      <h3 class="order-detail__summary-title">Tóm tắt thanh toán</h3>
      
      <div class="order-detail__summary-row">
        <span>Tạm tính:</span>
        <span>₫<?php echo e(number_format($order->subtotal, 0, ',', '.')); ?></span>
      </div>
      
      <?php if($order->discount > 0): ?>
        <div class="order-detail__summary-row order-detail__summary-row--discount">
          <span>Giảm giá:</span>
          <span>-₫<?php echo e(number_format($order->discount, 0, ',', '.')); ?></span>
        </div>
      <?php endif; ?>

      <hr class="order-detail__divider">

      <div class="order-detail__summary-row order-detail__summary-row--total">
        <span>Tổng cộng:</span>
        <span class="order-detail__summary-total-amount">₫<?php echo e(number_format($order->total, 0, ',', '.')); ?></span>
      </div>

      <?php if($order->status === 'pending'): ?>
        <div class="order-detail__payment-warning">
          <p class="order-detail__payment-warning-title">Đơn hàng chưa được thanh toán</p>
          <div class="order-detail__payment-buttons">
            <a href="<?php echo e(route('payment.gateway', ['order' => $order->id, 'method' => 'momo'])); ?>" 
               class="order-detail__payment-button order-detail__payment-button--momo">
              <i class="fas fa-wallet"></i> Thanh toán MoMo
            </a>
            <a href="<?php echo e(route('payment.gateway', ['order' => $order->id, 'method' => 'vnpay'])); ?>" 
               class="order-detail__payment-button order-detail__payment-button--vnpay">
              <i class="fas fa-credit-card"></i> Thanh toán VNPay
            </a>
            <a href="<?php echo e(route('payment.bank-transfer', $order)); ?>" 
               class="order-detail__payment-button order-detail__payment-button--bank">
              <i class="fas fa-university"></i> Chuyển khoản
            </a>
          </div>
        </div>
      <?php endif; ?>

      <?php if($order->payment): ?>
        <div class="order-detail__payment-info">
          <h4 class="order-detail__payment-info-title">Thông tin thanh toán</h4>
          <div class="order-detail__payment-info-grid">
            <div class="order-detail__payment-info-row">
              <span class="order-detail__payment-info-label">Phương thức:</span>
              <span class="order-detail__payment-info-value">
                <?php if($order->payment->provider === 'momo'): ?> Ví MoMo
                <?php elseif($order->payment->provider === 'vnpay'): ?> VNPay
                <?php elseif($order->payment->provider === 'bank_transfer'): ?> Chuyển khoản
                <?php else: ?> <?php echo e($order->payment->provider); ?>

                <?php endif; ?>
              </span>
            </div>
            <div class="order-detail__payment-info-row">
              <span class="order-detail__payment-info-label">Mã giao dịch:</span>
              <span class="order-detail__payment-info-value order-detail__payment-info-value--mono"><?php echo e($order->payment->transaction_id); ?></span>
            </div>
            <div class="order-detail__payment-info-row">
              <span class="order-detail__payment-info-label">Trạng thái:</span>
              <span class="order-detail__payment-status-badge order-detail__payment-status-badge--<?php echo e($order->payment->status); ?>">
                <?php if($order->payment->status === 'succeeded'): ?>
                  Thành công
                <?php elseif($order->payment->status === 'failed'): ?>
                  Thất bại
                <?php else: ?>
                  Đang xử lý
                <?php endif; ?>
              </span>
            </div>
            <div class="order-detail__payment-info-row">
              <span class="order-detail__payment-info-label">Thời gian:</span>
              <span><?php echo e($order->payment->created_at->format('d/m/Y H:i')); ?></span>
            </div>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\elearning\resources\views/orders/show.blade.php ENDPATH**/ ?>