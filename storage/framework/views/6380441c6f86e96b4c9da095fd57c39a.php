

<?php $__env->startSection('title', 'Đặt câu hỏi - ' . $course->title); ?>

<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/qa.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="qa-container">
    <!-- Breadcrumb -->
    <nav class="qa-breadcrumb">
        <a href="<?php echo e(route('home')); ?>">Trang chủ</a>
        <span>/</span>
        <a href="<?php echo e(route('student.learn', $course)); ?>"><?php echo e($course->title); ?></a>
        <span>/</span>
        <a href="<?php echo e(route('questions.index', $course)); ?>">Hỏi đáp</a>
        <span>/</span>
        <span>Đặt câu hỏi</span>
    </nav>

    <!-- Header -->
    <div class="qa-header">
        <h1>Đặt câu hỏi mới</h1>
        <p>Đặt câu hỏi về khóa học: <strong><?php echo e($course->title); ?></strong></p>
    </div>

    <!-- Form -->
    <div class="question-form-container">
        <form action="<?php echo e(route('questions.store', $course)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            
            <!-- Lesson Selection -->
            <div class="form-group">
                <label for="lesson_id" class="form-label">
                    Bài học liên quan (tùy chọn)
                </label>
                <select name="lesson_id" id="lesson_id" class="form-control">
                    <option value="">-- Câu hỏi chung về khóa học --</option>
                    <?php $__currentLoopData = $lessons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lessonItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($lessonItem->id); ?>" <?php echo e((old('lesson_id') == $lessonItem->id || (isset($lesson) && $lesson->id == $lessonItem->id)) ? 'selected' : ''); ?>>
                            <?php echo e($lessonItem->title); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php $__errorArgs = ['lesson_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="form-error"><?php echo e($message); ?></span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Title -->
            <div class="form-group">
                <label for="title" class="form-label">
                    Tiêu đề câu hỏi <span class="required">*</span>
                </label>
                <input type="text" name="title" id="title" value="<?php echo e(old('title')); ?>" 
                       placeholder="Ví dụ: Làm thế nào để..."
                       required
                       class="form-control">
                <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="form-error"><?php echo e($message); ?></span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Content -->
            <div class="form-group">
                <label for="content" class="form-label">
                    Nội dung câu hỏi <span class="required">*</span>
                </label>
                <textarea name="content" id="content" rows="8" required
                          placeholder="Mô tả chi tiết câu hỏi của bạn..."
                          class="form-control form-textarea"><?php echo e(old('content')); ?></textarea>
                <?php $__errorArgs = ['content'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="form-error"><?php echo e($message); ?></span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                <small class="form-hint">
                    <i class="fas fa-info-circle"></i> Hãy mô tả chi tiết để giảng viên có thể trả lời tốt hơn.
                </small>
            </div>

            <!-- Tips -->
            <div class="tips-box">
                <strong class="tips-title">
                    <i class="fas fa-lightbulb"></i> Mẹo đặt câu hỏi hiệu quả:
                </strong>
                <ul>
                    <li>Sử dụng tiêu đề rõ ràng, ngắn gọn</li>
                    <li>Mô tả chi tiết vấn đề bạn gặp phải</li>
                    <li>Đính kèm ảnh chụp màn hình nếu cần</li>
                    <li>Tìm kiếm câu hỏi tương tự trước khi đặt câu hỏi mới</li>
                </ul>
            </div>

            <!-- Buttons -->
            <div class="form-actions">
                <button type="submit" class="btn-submit">
                    <i class="fas fa-paper-plane"></i> Gửi câu hỏi
                </button>
                <a href="<?php echo e(route('questions.index', $course)); ?>" class="btn-cancel">
                    Hủy
                </a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\elearning\resources\views/questions/create.blade.php ENDPATH**/ ?>