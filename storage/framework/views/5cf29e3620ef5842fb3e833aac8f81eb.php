

<?php $__env->startSection('title', 'Chi tiết Câu hỏi'); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/qa.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="admin-page">
    <div style="margin-bottom: 20px;">
        <a href="<?php echo e(route('admin.questions.index')); ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <!-- Question -->
    <div class="admin-card" style="margin-bottom: 30px;">
        <div class="question-detail-header" style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 20px;">
            <div>
                <h1 class="admin-question-title"><?php echo e($question->title); ?></h1>
                <div class="question-meta">
                    <span><strong>Khóa học:</strong> <?php echo e($question->course->title); ?></span>
                    <?php if($question->lesson): ?>
                        <span><strong>Bài học:</strong> <?php echo e($question->lesson->title); ?></span>
                    <?php endif; ?>
                    <span><strong>Người hỏi:</strong> <?php echo e($question->user->name); ?></span>
                    <span><strong>Ngày:</strong> <?php echo e($question->created_at->format('d/m/Y H:i')); ?></span>
                    <span><strong>Lượt xem:</strong> <?php echo e($question->views); ?></span>
                </div>
            </div>
            
            <div style="display: flex; gap: 8px;">
                <?php if($question->is_resolved): ?>
                    <span class="badge-resolved" style="padding: 8px 16px;">
                        <i class="fas fa-check"></i> Đã giải quyết
                    </span>
                <?php endif; ?>
                
                <?php if($question->status === 'pending'): ?>
                    <span class="badge-pending" style="padding: 8px 16px;">Chờ trả lời</span>
                <?php elseif($question->status === 'answered'): ?>
                    <span class="badge-answered" style="padding: 8px 16px;">Đã trả lời</span>
                <?php else: ?>
                    <span class="badge badge-secondary" style="padding: 8px 16px;">Đã đóng</span>
                <?php endif; ?>
            </div>
        </div>

        <div class="question-content-box"><?php echo e($question->content); ?></div>

        <div class="question-actions">
            <form action="<?php echo e(route('admin.questions.destroy', $question)); ?>" method="POST" style="display: inline;" onsubmit="return confirm('Bạn có chắc muốn xóa câu hỏi này?')">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-trash"></i> Xóa câu hỏi
                </button>
            </form>
        </div>
    </div>

    <!-- Answers -->
    <div class="admin-card">
        <h2 class="answers-title">
            Câu trả lời (<?php echo e($question->answers->count()); ?>)
        </h2>

        <?php if($question->answers->count() > 0): ?>
            <?php $__currentLoopData = $question->answers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $answer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="answer-item <?php echo e($answer->is_best_answer ? 'best-answer' : ''); ?>">
                    <div class="answer-header" style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 12px;">
                        <div>
                            <strong><?php echo e($answer->user->name); ?></strong>
                            <?php if($answer->user->role === 'instructor'): ?>
                                <span class="role-badge role-instructor">Giảng viên</span>
                            <?php elseif($answer->user->role === 'admin'): ?>
                                <span class="role-badge role-admin">Admin</span>
                            <?php endif; ?>
                            <?php if($answer->is_best_answer): ?>
                                <span class="best-answer-badge">
                                    <i class="fas fa-star"></i> Best Answer
                                </span>
                            <?php endif; ?>
                            <div class="answer-time">
                                <?php echo e($answer->created_at->format('d/m/Y H:i')); ?>

                            </div>
                        </div>
                        
                        <form action="<?php echo e(route('admin.answers.destroy', $answer)); ?>" method="POST" style="display: inline;" onsubmit="return confirm('Xóa câu trả lời này?')">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i> Xóa
                            </button>
                        </form>
                    </div>

                    <div class="answer-content"><?php echo e($answer->content); ?></div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
            <div class="empty-answers">
                <i class="fas fa-comments"></i>
                <p>Chưa có câu trả lời nào</p>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\elearning\resources\views/admin/questions/show.blade.php ENDPATH**/ ?>