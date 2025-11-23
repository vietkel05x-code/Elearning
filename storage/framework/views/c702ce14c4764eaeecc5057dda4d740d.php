

<?php $__env->startSection('title', 'Hỏi đáp - ' . $course->title); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/qa.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="qa-container">
    <!-- Breadcrumb -->
    <nav class="qa-breadcrumb">
        <a href="<?php echo e(route('home')); ?>">Trang chủ</a>
        <span class="qa-breadcrumb-separator">/</span>
        <a href="<?php echo e(route('student.courses')); ?>">Khóa học của tôi</a>
        <span class="qa-breadcrumb-separator">/</span>
        <a href="<?php echo e(route('student.learn', $course)); ?>"><?php echo e($course->title); ?></a>
        <span class="qa-breadcrumb-separator">/</span>
        <span class="qa-breadcrumb-current">Hỏi đáp</span>
    </nav>

    <!-- Header -->
    <div class="qa-header">
        <div class="qa-header-content">
            <h1>Hỏi đáp</h1>
            <p><?php echo e($course->title); ?></p>
        </div>
        <a href="<?php echo e(route('questions.create', $course)); ?>" class="btn-ask-question">
            <i class="fas fa-plus"></i> Đặt câu hỏi
        </a>
    </div>

    <?php if(session('success')): ?>
        <div class="alert-success">
            <i class="fas fa-check-circle"></i> <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <!-- Questions List -->
    <?php if($questions->count() > 0): ?>
        <div class="questions-list">
            <?php $__currentLoopData = $questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="question-item">
                    <a href="<?php echo e(route('questions.show', [$course, $question])); ?>" class="question-item-link">
                        <div class="question-item-content">
                            <!-- Stats -->
                            <div class="question-stats">
                                <div class="question-stat">
                                    <div class="question-stat-number"><?php echo e($question->answers_count); ?></div>
                                    <div class="question-stat-label">câu trả lời</div>
                                </div>
                                <div class="question-stat question-stat-views">
                                    <div class="question-stat-number"><?php echo e($question->views); ?></div>
                                    <div class="question-stat-label">lượt xem</div>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="question-body">
                                <h3 class="question-title">
                                    <?php echo e($question->title); ?>

                                    <?php if($question->is_resolved): ?>
                                        <span class="badge-resolved">
                                            <i class="fas fa-check"></i> Đã giải quyết
                                        </span>
                                    <?php endif; ?>
                                </h3>
                                
                                <p class="question-excerpt">
                                    <?php echo e(Str::limit(strip_tags($question->content), 200)); ?>

                                </p>

                                <div class="question-meta">
                                    <?php if($question->lesson): ?>
                                        <span><i class="fas fa-play-circle"></i> <?php echo e($question->lesson->title); ?></span>
                                    <?php else: ?>
                                        <span><i class="fas fa-book"></i> Câu hỏi chung</span>
                                    <?php endif; ?>
                                    
                                    <span><i class="fas fa-user"></i> <?php echo e($question->user->name); ?></span>
                                    <span><i class="fas fa-clock"></i> <?php echo e($question->created_at->diffForHumans()); ?></span>
                                    
                                    <?php if($question->status === 'pending'): ?>
                                        <span class="meta-status-pending"><i class="fas fa-hourglass-half"></i> Chờ trả lời</span>
                                    <?php elseif($question->status === 'answered'): ?>
                                        <span class="meta-status-answered"><i class="fas fa-comment-dots"></i> Đã có trả lời</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <!-- Pagination -->
        <div style="margin-top: 30px;">
            <?php echo e($questions->links()); ?>

        </div>
    <?php else: ?>
        <div class="empty-state">
            <i class="fas fa-comments empty-state-icon"></i>
            <h3>Chưa có câu hỏi nào</h3>
            <p>Hãy là người đầu tiên đặt câu hỏi!</p>
            <a href="<?php echo e(route('questions.create', $course)); ?>" class="btn-ask-question">
                <i class="fas fa-plus"></i> Đặt câu hỏi đầu tiên
            </a>
        </div>
    <?php endif; ?>

    <!-- Back Button -->
    <a href="<?php echo e(route('student.learn', $course)); ?>" class="back-link">
        <i class="fas fa-arrow-left"></i> Quay lại khóa học
    </a>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\elearning\resources\views/questions/index.blade.php ENDPATH**/ ?>