

<?php $__env->startSection('title', $question->title . ' - Hỏi đáp'); ?>

<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/qa.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="qa-container qa-container-wide">
    <!-- Breadcrumb -->
    <nav class="qa-breadcrumb">
        <a href="<?php echo e(route('home')); ?>">Trang chủ</a>
        <span>/</span>
        <a href="<?php echo e(route('student.learn', $course)); ?>"><?php echo e($course->title); ?></a>
        <span>/</span>
        <a href="<?php echo e(route('questions.index', $course)); ?>">Hỏi đáp</a>
        <span>/</span>
        <span><?php echo e(Str::limit($question->title, 50)); ?></span>
    </nav>

    <?php if(session('success')): ?>
        <div class="alert-success">
            <i class="fas fa-check-circle"></i> <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <!-- Question -->
    <div class="question-detail-card">
        <!-- Question Header -->
        <div class="question-detail-header">
            <h1><?php echo e($question->title); ?></h1>
            
            <div class="question-meta">
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
                <?php elseif($question->status === 'pending'): ?>
                    <span class="badge-pending">
                        <i class="fas fa-hourglass-half"></i> Chờ trả lời
                    </span>
                <?php elseif($question->status === 'answered'): ?>
                    <span class="badge-answered">
                        <i class="fas fa-comment-dots"></i> Đã có trả lời
                    </span>
                <?php endif; ?>
            </div>
        </div>

        <!-- Question Content -->
        <div class="question-detail-content"><?php echo e($question->content); ?></div>

        <!-- Question Actions -->
        <?php if(Auth::id() === $question->user_id): ?>
            <div class="question-actions">
                <?php if(!$question->is_resolved): ?>
                    <form action="<?php echo e(route('questions.resolve', [$course, $question])); ?>" method="POST" style="display: inline;">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn-resolve">
                            <i class="fas fa-check"></i> Đánh dấu đã giải quyết
                        </button>
                    </form>
                <?php endif; ?>
                
                <form action="<?php echo e(route('questions.destroy', [$course, $question])); ?>" method="POST" style="display: inline;" onsubmit="return confirm('Bạn có chắc muốn xóa câu hỏi này?')">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="btn-delete">
                        <i class="fas fa-trash"></i> Xóa câu hỏi
                    </button>
                </form>
            </div>
        <?php endif; ?>
    </div>

    <!-- Answers Section -->
    <div class="answers-section">
        <h2 class="answers-title">
            <?php echo e($question->answers->count()); ?> câu trả lời
        </h2>

        <?php if($question->answers->count() > 0): ?>
            <?php $__currentLoopData = $question->answers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $answer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="answer-item <?php echo e($answer->is_best_answer ? 'answer-best' : ''); ?>">
                    <!-- Answer Header -->
                    <div class="answer-header">
                        <div class="answer-avatar">
                            <?php echo e(strtoupper(substr($answer->user->name, 0, 1))); ?>

                        </div>
                        <div class="answer-author-info">
                            <div class="answer-author-name">
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
                                        <i class="fas fa-check"></i> CÂU TRẢ LỜI TỐT NHẤT
                                    </span>
                                <?php endif; ?>
                            </div>
                            <div class="answer-time">
                                <?php echo e($answer->created_at->diffForHumans()); ?>

                            </div>
                        </div>
                    </div>

                    <!-- Answer Content -->
                    <div class="answer-content"><?php echo e($answer->content); ?></div>

                    <!-- Answer Actions -->
                    <div class="answer-actions">
                        <?php if(Auth::id() === $question->user_id && !$answer->is_best_answer && !$question->is_resolved): ?>
                            <form action="<?php echo e(route('questions.select-best', [$course, $question, $answer])); ?>" method="POST" style="display: inline;">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn-select-best">
                                    <i class="fas fa-check-circle"></i> Chọn làm câu trả lời tốt nhất
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
            <div class="empty-state">
                <i class="fas fa-comments empty-state-icon"></i>
                <p>Chưa có câu trả lời nào. Hãy chờ giảng viên trả lời!</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Back Button -->
    <a href="<?php echo e(route('questions.index', $course)); ?>" class="back-link">
        <i class="fas fa-arrow-left"></i> Quay lại danh sách câu hỏi
    </a>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\elearning\resources\views/questions/show.blade.php ENDPATH**/ ?>