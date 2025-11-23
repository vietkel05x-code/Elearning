

<?php $__env->startSection('title', 'Đăng nhập'); ?>

<?php $__env->startSection('content'); ?>
<div class="auth-container">
    <h2>Đăng nhập</h2>
    <form method="POST" action="/login">
        <?php echo csrf_field(); ?>
        <label>Email</label>
        <input type="email" name="email" value="<?php echo e(old('email')); ?>" required>

        <label>Mật khẩu</label>
        <input type="password" name="password" required>

        <div class="remember">
            <input type="checkbox" name="remember"> Ghi nhớ đăng nhập
        </div>

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

        <button type="submit">Đăng nhập</button>

        <p>Chưa có tài khoản? <a href="/register">Đăng ký</a></p>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\elearning\resources\views/auth/login.blade.php ENDPATH**/ ?>