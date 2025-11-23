

<?php $__env->startSection('title', $user->id ? 'Sửa người dùng' : 'Thêm người dùng'); ?>
<?php $__env->startSection('page-title', $user->id ? 'Sửa người dùng' : 'Thêm người dùng'); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/admin/admin.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<section class="admin-form-page admin-form-page--narrow">
  <h1 class="admin-form-page__title"><?php echo e($user->id ? 'Sửa người dùng' : 'Thêm người dùng'); ?></h1>

  <?php if($errors->any()): ?>
    <div class="alert alert--error">
      <ul class="admin-error-list">
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <li><?php echo e($error); ?></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </ul>
    </div>
  <?php endif; ?>

  <form action="<?php echo e($user->id ? route('admin.users.update', $user) : route('admin.users.store')); ?>" method="POST" class="admin-form">
    <?php echo csrf_field(); ?>
    <?php if($user->id): ?>
      <?php echo method_field('PUT'); ?>
    <?php endif; ?>

    <?php if($user->id): ?>
      
      <div class="admin-user-info">
        <h3 class="admin-user-info__title">Thông tin người dùng</h3>
        
        <div class="admin-user-info__field">
          <label class="admin-user-info__label">Họ và tên</label>
          <div class="admin-user-info__value"><?php echo e($user->name); ?></div>
        </div>

        <div class="admin-user-info__field">
          <label class="admin-user-info__label">Email</label>
          <div class="admin-user-info__value"><?php echo e($user->email); ?></div>
        </div>

        <div class="admin-user-info__field admin-user-info__field--last">
          <label class="admin-user-info__label">Ngày tạo</label>
          <div class="admin-user-info__value"><?php echo e($user->created_at->format('d/m/Y H:i')); ?></div>
        </div>
      </div>

      <div class="admin-form__field">
        <label for="role" class="admin-form__label">Vai trò *</label>
        <select name="role" id="role" required class="admin-form__select">
          <option value="student" <?php echo e(old('role', $user->role) == 'student' ? 'selected' : ''); ?>>Học viên</option>
          <option value="instructor" <?php echo e(old('role', $user->role) == 'instructor' ? 'selected' : ''); ?>>Giảng viên</option>
          <option value="admin" <?php echo e(old('role', $user->role) == 'admin' ? 'selected' : ''); ?>>Quản trị</option>
        </select>
        <small class="admin-help-text">Chỉ có thể thay đổi vai trò của người dùng</small>
      </div>
    <?php else: ?>
      
      <div class="admin-form__field">
        <label for="name" class="admin-form__label">Họ và tên *</label>
        <input type="text" name="name" id="name" value="<?php echo e(old('name', $user->name)); ?>" required class="admin-form__input">
      </div>

      <div class="admin-form__field">
        <label for="email" class="admin-form__label">Email *</label>
        <input type="email" name="email" id="email" value="<?php echo e(old('email', $user->email)); ?>" required class="admin-form__input">
      </div>

      <div class="admin-form__field">
        <label for="role" class="admin-form__label">Vai trò *</label>
        <select name="role" id="role" required class="admin-form__select">
          <option value="student" <?php echo e(old('role', $user->role) == 'student' ? 'selected' : ''); ?>>Học viên</option>
          <option value="instructor" <?php echo e(old('role', $user->role) == 'instructor' ? 'selected' : ''); ?>>Giảng viên</option>
          <option value="admin" <?php echo e(old('role', $user->role) == 'admin' ? 'selected' : ''); ?>>Quản trị</option>
        </select>
      </div>

      <div class="admin-form__field">
        <label for="password" class="admin-form__label">Mật khẩu *</label>
        <input type="password" name="password" id="password" required class="admin-form__input" minlength="8">
      </div>

      <div class="admin-form__field">
        <label for="password_confirmation" class="admin-form__label">Xác nhận mật khẩu *</label>
        <input type="password" name="password_confirmation" id="password_confirmation" required class="admin-form__input" minlength="8">
      </div>
    <?php endif; ?>

    <div class="admin-form__actions">
      <a href="<?php echo e(route('admin.users.index')); ?>" class="btn btn--outline admin-form-actions__button">
        Hủy
      </a>
      <button type="submit" class="btn btn--primary admin-form-actions__button">
        <?php echo e($user->id ? 'Cập nhật' : 'Tạo'); ?>

      </button>
    </div>
  </form>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\elearning\resources\views/admin/users/form.blade.php ENDPATH**/ ?>