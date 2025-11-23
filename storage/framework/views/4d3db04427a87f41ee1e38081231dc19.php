

<?php $__env->startSection('title', 'Chỉnh sửa thông tin'); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/pages/profile.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<section class="profile-edit-page">
  <h1 class="profile-edit-page__title">Chỉnh sửa thông tin cá nhân</h1>

  <?php if($errors->any()): ?>
    <div class="alert alert--error">
      <ul class="alert__list">
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <li class="alert__list-item"><?php echo e($error); ?></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </ul>
    </div>
  <?php endif; ?>

  <form action="<?php echo e(route('profile.update')); ?>" method="POST" enctype="multipart/form-data" class="profile-form">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>

    <!-- Avatar Upload -->
    <div class="profile-form__avatar-section">
      <div class="profile-form__avatar-preview">
        <?php if(Auth::user()->avatar): ?>
          <img src="<?php echo e(Auth::user()->avatar_url); ?>" alt="Avatar" id="avatarPreview">
        <?php else: ?>
          <span id="avatarPreview"><?php echo e(strtoupper(substr(Auth::user()->name, 0, 1))); ?></span>
        <?php endif; ?>
      </div>
      <label for="avatar" class="profile-form__avatar-label">
        Chọn ảnh đại diện
      </label>
      <input type="file" name="avatar" id="avatar" accept="image/*" class="profile-form__avatar-input" onchange="previewAvatar(this)">
    </div>

    <!-- Name -->
    <div class="profile-form__field">
      <label for="name" class="profile-form__label">Họ và tên *</label>
      <input type="text" name="name" id="name" value="<?php echo e(old('name', Auth::user()->name)); ?>" required
             class="profile-form__input">
    </div>

    <!-- Email (read-only) -->
    <div class="profile-form__field">
      <label class="profile-form__label">Email</label>
      <div class="profile-form__readonly" style="background:#f5f5f5;border:1px solid #ddd;padding:.65rem .75rem;border-radius:6px;font-size:.95rem;box-sizing:border-box;word-break:break-word;">
        <?php echo e(Auth::user()->email); ?>

      </div>
      <small class="profile-form__help">Email được cố định để bảo mật. Liên hệ hỗ trợ nếu cần thay đổi.</small>
    </div>

    <!-- Current Password -->
    <div class="profile-form__field">
      <label for="current_password" class="profile-form__label">Mật khẩu hiện tại</label>
      <input type="password" name="current_password" id="current_password"
             class="profile-form__input"
             placeholder="Chỉ điền nếu muốn đổi mật khẩu">
      <small class="profile-form__help">Để trống nếu không muốn đổi mật khẩu</small>
    </div>

    <!-- New Password -->
    <div class="profile-form__field">
      <label for="new_password" class="profile-form__label">Mật khẩu mới</label>
      <input type="password" name="new_password" id="new_password"
             class="profile-form__input"
             placeholder="Tối thiểu 8 ký tự">
    </div>

    <!-- Confirm Password -->
    <div class="profile-form__field">
      <label for="new_password_confirmation" class="profile-form__label">Xác nhận mật khẩu mới</label>
      <input type="password" name="new_password_confirmation" id="new_password_confirmation"
             class="profile-form__input">
    </div>

    <!-- Buttons -->
    <div class="profile-form__actions">
      <a href="<?php echo e(route('profile.show')); ?>" class="profile-form__cancel">
        Hủy
      </a>
      <button type="submit" class="profile-form__submit">
        Lưu thay đổi
      </button>
    </div>
  </form>
</section>

<script>
function previewAvatar(input) {
  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = function(e) {
      const preview = document.getElementById('avatarPreview');
      preview.innerHTML = `<img src="${e.target.result}" alt="Avatar" style="width:100%;height:100%;object-fit:cover">`;
    };
    reader.readAsDataURL(input.files[0]);
  }
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\elearning\resources\views/profile/edit.blade.php ENDPATH**/ ?>