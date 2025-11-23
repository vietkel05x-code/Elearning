

<?php $__env->startSection('title', 'Thông tin cá nhân'); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/pages/profile.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<section class="profile-page">
  <h1 class="profile-page__title">Thông tin cá nhân</h1>

  <?php if(session('success')): ?>
    <div class="alert alert--success"><?php echo e(session('success')); ?></div>
  <?php endif; ?>

  <div class="profile-grid">
    <!-- Avatar Section -->
    <div class="profile-avatar">
      <div class="profile-avatar__container">
        <?php if(Auth::user()->avatar): ?>
          <img src="<?php echo e(Auth::user()->avatar_url); ?>" alt="Avatar" class="profile-avatar__image">
        <?php else: ?>
          <span class="profile-avatar__initial"><?php echo e(strtoupper(substr(Auth::user()->name, 0, 1))); ?></span>
        <?php endif; ?>
      </div>
      <a href="<?php echo e(route('profile.edit')); ?>" class="profile-avatar__button">
        Chỉnh sửa thông tin
      </a>
    </div>

    <!-- Info Section -->
    <div class="profile-info card">
      <h2 class="profile-info__title">Thông tin tài khoản</h2>
      
      <div class="profile-info__list">
        <div>
          <p class="profile-info__item-label">Họ và tên</p>
          <p class="profile-info__item-value"><?php echo e(Auth::user()->name); ?></p>
        </div>

        <div>
          <p class="profile-info__item-label">Email</p>
          <p class="profile-info__item-value profile-info__item-value--normal"><?php echo e(Auth::user()->email); ?></p>
        </div>

        <div>
          <p class="profile-info__item-label">Vai trò</p>
          <p class="profile-info__item-value">
            <span class="profile-info__badge"><?php echo e(ucfirst(Auth::user()->role)); ?></span>
          </p>
        </div>

        <div>
          <p class="profile-info__item-label">Ngày tham gia</p>
          <p class="profile-info__item-value profile-info__item-value--normal"><?php echo e(Auth::user()->created_at->format('d/m/Y')); ?></p>
        </div>
      </div>

      <hr class="profile-info__divider">

      <div class="profile-info__stats">
        <div>
          <p class="profile-info__stat-value"><?php echo e(Auth::user()->enrollments()->count()); ?></p>
          <p class="profile-info__stat-label">Khóa học đã đăng ký</p>
        </div>
        <div>
          <p class="profile-info__stat-value"><?php echo e(Auth::user()->orders()->count()); ?></p>
          <p class="profile-info__stat-label">Đơn hàng</p>
        </div>
        <div>
          <p class="profile-info__stat-value"><?php echo e(Auth::user()->reviews()->count()); ?></p>
          <p class="profile-info__stat-label">Đánh giá đã gửi</p>
        </div>
      </div>
    </div>
  </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\elearning\resources\views/profile/show.blade.php ENDPATH**/ ?>