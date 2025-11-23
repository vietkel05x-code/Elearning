

<?php $__env->startSection('title', 'Thanh toán'); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/pages/checkout.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<section class="checkout-page">
  <h1 class="checkout-page__title">Thanh toán</h1>

  <div class="checkout-grid">
    <!-- Order Summary -->
    <div class="checkout-order">
      <h2 class="checkout-order__title">Đơn hàng của bạn</h2>
      
      <div class="checkout-order__list">
        <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div class="checkout-order__item">
            <img src="<?php echo e($course->thumbnail_url); ?>" alt="<?php echo e($course->title); ?>" 
                 class="checkout-order__image">
            <div class="checkout-order__content">
              <h4 class="checkout-order__course-title"><?php echo e($course->title); ?></h4>
              <p class="checkout-order__instructor"><?php echo e($course->instructor->name ?? 'Instructor'); ?></p>
              <p class="checkout-order__price">
                ₫<?php echo e(number_format($course->price, 0, ',', '.')); ?>

              </p>
            </div>
          </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>

      <?php
        $isDirectCheckout = session()->has('direct_checkout_course');
        $directCourseId = session()->get('direct_checkout_course');
      ?>
      
      <?php if(!$isDirectCheckout): ?>
        <a href="<?php echo e(route('cart.index')); ?>" class="checkout-order__back-link">
          ← Quay lại giỏ hàng
        </a>
      <?php else: ?>
        <a href="<?php echo e(route('courses.show', $courses[0]->slug)); ?>" class="checkout-order__back-link">
          ← Quay lại khóa học
        </a>
      <?php endif; ?>
    </div>

    <!-- Payment Summary -->
    <div class="checkout-summary">
      <div class="checkout-summary__card card">
        <h3 class="checkout-summary__title">Tóm tắt đơn hàng</h3>
        
        <!-- Coupon Code Section -->
        <div class="checkout-coupon">
          <?php if(session('success')): ?>
            <div class="alert alert--success" style="margin-bottom: var(--spacing-md);">
              <?php echo e(session('success')); ?>

            </div>
          <?php endif; ?>
          
          <?php if($couponCode && $coupon): ?>
            <div class="checkout-coupon__applied">
              <div class="checkout-coupon__info">
                <div class="checkout-coupon__code">Mã giảm giá: <?php echo e($couponCode); ?></div>
                <div class="checkout-coupon__discount">
                  <?php if($coupon->type === 'percent'): ?>
                    Giảm <?php echo e($coupon->value); ?>%
                  <?php else: ?>
                    Giảm ₫<?php echo e(number_format($coupon->value, 0, ',', '.')); ?>

                  <?php endif; ?>
                </div>
              </div>
              <form action="<?php echo e(route('checkout.remove-coupon')); ?>" method="POST" style="margin:0">
                <?php echo csrf_field(); ?>
                <button type="submit" class="checkout-coupon__remove-btn" 
                        onclick="return confirm('Bạn có chắc muốn xóa mã giảm giá?')">
                  ✕
                </button>
              </form>
            </div>
          <?php else: ?>
            <form action="<?php echo e(route('checkout.apply-coupon')); ?>" method="POST" class="checkout-coupon__form">
              <?php echo csrf_field(); ?>
              <input type="text" name="coupon_code" placeholder="Nhập mã giảm giá" 
                     class="checkout-coupon__input"
                     value="<?php echo e(old('coupon_code')); ?>">
              <button type="submit" class="btn btn--success">
                Áp dụng
              </button>
            </form>
            <?php if(session('error')): ?>
              <div class="alert alert--error" style="margin-top: var(--spacing-sm);">
                <?php echo e(session('error')); ?>

              </div>
            <?php endif; ?>
          <?php endif; ?>
        </div>

        <div class="checkout-totals">
          <div class="checkout-totals__row">
            <span>Tạm tính:</span>
            <span>₫<?php echo e(number_format($subtotal, 0, ',', '.')); ?></span>
          </div>
          
          <?php if($discount > 0): ?>
            <div class="checkout-totals__row checkout-totals__row--discount">
              <span>Giảm giá:</span>
              <span>-₫<?php echo e(number_format($discount, 0, ',', '.')); ?></span>
            </div>
          <?php endif; ?>

          <hr class="checkout-totals__divider">

          <div class="checkout-totals__row checkout-totals__row--total">
            <span>Tổng cộng:</span>
            <span class="checkout-totals__total-amount">₫<?php echo e(number_format($total, 0, ',', '.')); ?></span>
          </div>
        </div>

        <?php
          $isDirectCheckout = session()->has('direct_checkout_course');
          $directCourse = $isDirectCheckout ? $courses[0] : null;
        ?>
        
        <form action="<?php echo e($isDirectCheckout ? route('checkout.process-direct', $directCourse->id) : route('checkout.process')); ?>" method="POST" id="checkoutForm">
          <?php echo csrf_field(); ?>
          
          <!-- Payment Method Selection -->
          <div class="checkout-payment">
            <h4 class="checkout-payment__title">Phương thức thanh toán</h4>
            <div class="checkout-payment__methods">
              <label class="checkout-payment__method">
                <input type="radio" name="payment_method" value="momo" required checked>
                <div class="checkout-payment__method-content">
                  <div class="checkout-payment__method-header">
                    <img src="https://developers.momo.vn/v3.1/images/logo.png" alt="MoMo" 
                         class="checkout-payment__method-icon">
                    <span class="checkout-payment__method-name">Ví MoMo</span>
                  </div>
                  <small class="checkout-payment__method-desc">Thanh toán nhanh chóng qua ví điện tử MoMo</small>
                </div>
              </label>

              <label class="checkout-payment__method">
                <input type="radio" name="payment_method" value="vnpay" required>
                <div class="checkout-payment__method-content">
                  <div class="checkout-payment__method-header">
                    <div class="checkout-payment__method-icon checkout-payment__method-icon--vnpay">VNPay</div>
                    <span class="checkout-payment__method-name">VNPay</span>
                  </div>
                  <small class="checkout-payment__method-desc">Thanh toán qua cổng VNPay</small>
                </div>
              </label>

              <label class="checkout-payment__method">
                <input type="radio" name="payment_method" value="bank_transfer" required>
                <div class="checkout-payment__method-content">
                  <div class="checkout-payment__method-header">
                    <div class="checkout-payment__method-icon checkout-payment__method-icon--bank">🏦</div>
                    <span class="checkout-payment__method-name">Chuyển khoản ngân hàng</span>
                  </div>
                  <small class="checkout-payment__method-desc">Chuyển khoản trực tiếp qua ngân hàng</small>
                </div>
              </label>
            </div>
          </div>

          <button type="submit" class="checkout-payment__submit">
            Tiến hành thanh toán
          </button>
        </form>

        <p class="checkout-payment__terms">
          Bằng cách đặt hàng, bạn đồng ý với các điều khoản và điều kiện của chúng tôi
        </p>
      </div>
    </div>
  </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\elearning\resources\views/checkout/index.blade.php ENDPATH**/ ?>