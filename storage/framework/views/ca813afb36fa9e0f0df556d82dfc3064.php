

<?php $__env->startSection('title', 'Đăng ký'); ?>

<?php $__env->startSection('content'); ?>
<div class="auth-container">
    <h2>Đăng ký</h2>
    <form method="POST" action="/register">
        <?php echo csrf_field(); ?>
        <label>Tên</label>
        <input type="text" name="name" value="<?php echo e(old('name')); ?>" required>

        <label>Email</label>
        <input type="email" name="email" value="<?php echo e(old('email')); ?>" required>

        <label>Mật khẩu</label>
        <input type="password" name="password" required>

        <label>Nhập lại mật khẩu</label>
        <input type="password" name="password_confirmation" required>

        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <p class="error"><?php echo e($message); ?></p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

        <button type="submit">Đăng ký</button>
        <p>Đã có tài khoản? <a href="/login">Đăng nhập</a></p>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\elearning\resources\views/auth/register.blade.php ENDPATH**/ ?>