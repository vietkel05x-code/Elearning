

<?php $__env->startSection('title', 'Gửi thông báo'); ?>
<?php $__env->startSection('page-title', 'Gửi thông báo'); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/admin/admin.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<section class="admin-form-page admin-form-page--narrow">
  <h1 class="admin-form-page__title">Gửi thông báo</h1>

  <?php if($errors->any()): ?>
    <div class="alert alert--error">
      <ul class="admin-error-list">
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <li><?php echo e($error); ?></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </ul>
    </div>
  <?php endif; ?>

  <form action="<?php echo e(route('admin.notifications.store')); ?>" method="POST" class="admin-form">
    <?php echo csrf_field(); ?>

    <div class="admin-form__field">
      <label for="title" class="admin-form__label">Tiêu đề *</label>
      <input type="text" name="title" id="title" value="<?php echo e(old('title')); ?>" required
             class="admin-form__input" placeholder="Ví dụ: Khóa học mới đã được thêm vào">
    </div>

    <div class="admin-form__field">
      <label for="body" class="admin-form__label">Nội dung *</label>
      <textarea name="body" id="body" rows="6" required class="admin-form__textarea"
                placeholder="Nhập nội dung thông báo..."><?php echo e(old('body')); ?></textarea>
    </div>

    <div class="admin-form__field">
      <label for="target" class="admin-form__label">Gửi đến *</label>
      <select name="target" id="target" required class="admin-form__select">
        <option value="all" <?php echo e(old('target') == 'all' ? 'selected' : ''); ?>>Tất cả người dùng (<?php echo e($totalUsers); ?> học viên)</option>
        <option value="students" <?php echo e(old('target') == 'students' ? 'selected' : ''); ?>>Chỉ học viên</option>
        <option value="admins" <?php echo e(old('target') == 'admins' ? 'selected' : ''); ?>>Chỉ quản trị viên</option>
      </select>
    </div>

    <div class="admin-form__actions">
      <a href="<?php echo e(route('admin.notifications.index')); ?>" class="btn btn--outline admin-form-actions__button">
        Hủy
      </a>
      <button type="submit" class="btn btn--primary admin-form-actions__button">
        Gửi thông báo
      </button>
    </div>
  </form>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\elearning\resources\views/admin/notifications/form.blade.php ENDPATH**/ ?>