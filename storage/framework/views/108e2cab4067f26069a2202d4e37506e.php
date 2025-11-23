

<?php $__env->startSection('title', 'Quản lý người dùng'); ?>
<?php $__env->startSection('page-title', 'Quản lý người dùng'); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/admin/admin.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<section class="admin-page">
  <div class="admin-page-header">
    <h1 class="admin-page-header__title">Quản lý người dùng</h1>
    <a href="<?php echo e(route('admin.users.create')); ?>" class="admin-page-header__action">
      + Thêm người dùng
    </a>
  </div>

  <?php if(session('success')): ?>
    <div class="alert alert--success"><?php echo e(session('success')); ?></div>
  <?php endif; ?>

  <?php if(session('error')): ?>
    <div class="alert alert--error"><?php echo e(session('error')); ?></div>
  <?php endif; ?>

  <!-- Filters -->
  <form method="GET" action="<?php echo e(route('admin.users.index')); ?>" class="admin-filters card admin-mb--lg">
    <div class="admin-form__grid admin-form__grid--3cols admin-flex--center-items" style="align-items: end;">
      <div>
        <label class="admin-form__label">Tìm kiếm</label>
        <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Tên, email..." 
               class="admin-form__input">
      </div>
      <div>
        <label class="admin-form__label">Vai trò</label>
        <select name="role" class="admin-form__select">
          <option value="">Tất cả</option>
          <option value="student" <?php echo e(request('role') == 'student' ? 'selected' : ''); ?>>Học viên</option>
          <option value="admin" <?php echo e(request('role') == 'admin' ? 'selected' : ''); ?>>Quản trị</option>
        </select>
      </div>
      <div class="admin-flex admin-flex--gap-sm">
        <button type="submit" class="btn btn--primary">Lọc</button>
        <a href="<?php echo e(route('admin.users.index')); ?>" class="btn btn--outline">Reset</a>
      </div>
    </div>
  </form>

  <!-- Users Table -->
  <?php if($users->count() > 0): ?>
    <div class="admin-table-wrapper">
      <table class="admin-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Tên</th>
            <th>Email</th>
            <th>Vai trò</th>
            <th>Ngày tạo</th>
            <th class="admin-table__cell--center">Hành động</th>
          </tr>
        </thead>
        <tbody>
          <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
              <td><?php echo e($user->id); ?></td>
              <td class="admin-table__cell--bold"><?php echo e($user->name); ?></td>
              <td><?php echo e($user->email); ?></td>
              <td>
                <span class="admin-badge" style="background: <?php echo e($user->role == 'admin' ? 'var(--color-primary)' : 'var(--color-success)'); ?>; color: white;">
                  <?php echo e(ucfirst($user->role)); ?>

                </span>
              </td>
              <td class="admin-table__cell--secondary">
                <?php echo e($user->created_at->format('d/m/Y')); ?>

              </td>
              <td class="admin-table__cell--center">
                <div class="admin-actions-container">
                  <a href="<?php echo e(route('admin.users.edit', $user)); ?>" class="btn btn--outline btn--sm">
                    Sửa
                  </a>
                  <?php if($user->id !== auth()->id()): ?>
                    <form action="<?php echo e(route('admin.users.destroy', $user)); ?>" method="POST" class="admin-actions-container--inline">
                      <?php echo csrf_field(); ?>
                      <?php echo method_field('DELETE'); ?>
                      <button type="submit" onclick="return confirm('Bạn có chắc muốn xóa người dùng này?')" 
                              class="btn btn--danger btn--sm">
                        Xóa
                      </button>
                    </form>
                  <?php endif; ?>
                </div>
              </td>
            </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
      </table>
    </div>

    <div class="admin-pagination">
      <?php echo e($users->links()); ?>

    </div>
  <?php else: ?>
    <div class="admin-card card">
      <p class="admin-empty-state">
        Không tìm thấy người dùng nào
      </p>
    </div>
  <?php endif; ?>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\elearning\resources\views/admin/users/index.blade.php ENDPATH**/ ?>