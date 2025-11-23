

<?php $__env->startSection('title', $category->id ? 'Sửa danh mục' : 'Thêm danh mục'); ?>
<?php $__env->startSection('page-title', $category->id ? 'Sửa danh mục' : 'Thêm danh mục'); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/admin/admin.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<section class="admin-form-page admin-form-page--narrow">
  <h1 class="admin-form-page__title"><?php echo e($category->id ? 'Sửa danh mục' : 'Thêm danh mục'); ?></h1>

  <?php if($errors->any()): ?>
    <div class="alert alert--error">
      <ul class="admin-error-list">
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <li><?php echo e($error); ?></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </ul>
    </div>
  <?php endif; ?>

  <form action="<?php echo e($category->id ? route('admin.categories.update', $category) : route('admin.categories.store')); ?>" method="POST" class="admin-form">
    <?php echo csrf_field(); ?>
    <?php if($category->id): ?>
      <?php echo method_field('PUT'); ?>
    <?php endif; ?>

    <div class="admin-form__field">
      <label for="name" class="admin-form__label">Tên danh mục *</label>
      <input type="text" name="name" id="name" value="<?php echo e(old('name', $category->name)); ?>" required class="admin-form__input">
    </div>

    <div class="admin-form__field">
      <label for="slug" class="admin-form__label">Slug</label>
      <input type="text" name="slug" id="slug" value="<?php echo e(old('slug', $category->slug)); ?>" class="admin-form__input" placeholder="Tự động tạo từ tên nếu để trống">
      <small class="admin-help-text">Slug sẽ được tự động tạo từ tên nếu để trống</small>
    </div>

    <div class="admin-form__field">
      <label for="parent_id" class="admin-form__label">Danh mục cha</label>
      <select name="parent_id" id="parent_id" class="admin-form__select">
        <option value="">Không có (danh mục gốc)</option>
        <?php $__currentLoopData = $parentCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $parent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <option value="<?php echo e($parent->id); ?>" <?php echo e(old('parent_id', $category->parent_id) == $parent->id ? 'selected' : ''); ?>>
            <?php echo e($parent->name); ?>

          </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </select>
    </div>

    <div class="admin-form__field">
      <label for="description" class="admin-form__label">Mô tả</label>
      <textarea name="description" id="description" rows="4" class="admin-form__textarea"><?php echo e(old('description', $category->description)); ?></textarea>
    </div>

    <div class="admin-form__field">
      <label for="image" class="admin-form__label">Tên file ảnh (trong public/img/categories/)</label>
      <input type="text" name="image" id="image" value="<?php echo e(old('image', $category->image)); ?>" class="admin-form__input" placeholder="example.jpg">
    </div>

    <div class="admin-form__actions">
      <a href="<?php echo e(route('admin.categories.index')); ?>" class="btn btn--outline admin-form-actions__button">
        Hủy
      </a>
      <button type="submit" class="btn btn--primary admin-form-actions__button">
        <?php echo e($category->id ? 'Cập nhật' : 'Tạo'); ?>

      </button>
    </div>
  </form>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\elearning\resources\views/admin/categories/form.blade.php ENDPATH**/ ?>