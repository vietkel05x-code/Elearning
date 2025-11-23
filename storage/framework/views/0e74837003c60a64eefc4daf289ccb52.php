

<?php $__env->startSection('title', $question->title . ' - Hỏi đáp'); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/qa.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="qa-container">
    <nav class="qa-breadcrumb">
        <a href="<?php echo e(route('admin.questions.index')); ?>" class="back-link">
            <i class="fas fa-arrow-left"></i> Quay lại danh sách
        </a>
    </nav>

    <?php if(session('success')): ?>
        <div class="alert-success">
            <i class="fas fa-check-circle"></i> <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <!-- Question -->
    <div class="question-detail">
        <div class="question-detail-header">
            <h1><?php echo e($question->title); ?></h1>
            
            <div class="question-meta">
                <span class="course-name"><?php echo e($question->course->title); ?></span>
                
                <?php if($question->lesson): ?>
                    <span><i class="fas fa-play-circle"></i> <?php echo e($question->lesson->title); ?></span>
                <?php else: ?>
                    <span><i class="fas fa-book"></i> Câu hỏi chung</span>
                <?php endif; ?>
                
                <span><i class="fas fa-user"></i> <?php echo e($question->user->name); ?></span>
                <span><i class="fas fa-clock"></i> <?php echo e($question->created_at->diffForHumans()); ?></span>
                <span><i class="fas fa-eye"></i> <?php echo e($question->views); ?> lượt xem</span>
                
                <?php if($question->is_resolved): ?>
                    <span class="badge-resolved">
                        <i class="fas fa-check"></i> Đã giải quyết
                    </span>
                <?php endif; ?>
            </div>
        </div>

        <div class="question-content"><?php echo e($question->content); ?></div>
    </div>

    <!-- Answers -->
    <div class="answers-section">
        <h2 class="answers-title">
            <?php echo e($question->answers->count()); ?> câu trả lời
        </h2>

        <?php $__currentLoopData = $question->answers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $answer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="answer-item <?php echo e($answer->is_best_answer ? 'best-answer' : ''); ?>">
                <div class="answer-header">
                    <div class="user-avatar">
                        <?php echo e(strtoupper(substr($answer->user->name, 0, 1))); ?>

                    </div>
                    <div class="answer-author-info">
                        <div class="author-name">
                            <?php echo e($answer->user->name); ?>

                            <?php if($answer->user->role === 'instructor'): ?>
                                <span class="role-badge role-instructor">
                                    GIẢNG VIÊN
                                </span>
                            <?php elseif($answer->user->role === 'admin'): ?>
                                <span class="role-badge role-admin">
                                    ADMIN
                                </span>
                            <?php endif; ?>
                            <?php if($answer->is_best_answer): ?>
                                <span class="best-answer-badge">
                                    <i class="fas fa-star"></i> BEST ANSWER
                                </span>
                            <?php endif; ?>
                        </div>
                        <div class="answer-time"><?php echo e($answer->created_at->diffForHumans()); ?></div>
                    </div>

                    <?php if(Auth::id() === $answer->user_id): ?>
                        <form action="<?php echo e(route('instructor.answers.destroy', $answer)); ?>" method="POST" onsubmit="return confirm('Xóa câu trả lời?')">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn-delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    <?php endif; ?>
                </div>

                <div class="answer-content"><?php echo e($answer->content); ?></div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <!-- Answer Form -->
    <div class="answer-form-container">
        <h3 class="form-title">Trả lời câu hỏi</h3>
        
        <form action="<?php echo e(route('admin.questions.answer', $question)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            
            <div class="form-group">
                <label for="content" class="form-label">
                    Câu trả lời của bạn <span class="required">*</span>
                </label>
                <textarea name="content" id="content" rows="6" required
                          placeholder="Nhập câu trả lời chi tiết..."
                          class="form-control"><?php echo e(old('content')); ?></textarea>
                <?php $__errorArgs = ['content'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="error-message"><?php echo e($message); ?></span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <button type="submit" class="btn-submit">
                <i class="fas fa-paper-plane"></i> Gửi câu trả lời
            </button>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\elearning\resources\views/admin/instructor/questions/show.blade.php ENDPATH**/ ?>