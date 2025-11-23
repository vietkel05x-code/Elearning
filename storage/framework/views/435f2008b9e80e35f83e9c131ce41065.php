

<?php $__env->startSection('title', 'Quản lý Hỏi Đáp - Giảng viên'); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/qa.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="qa-container">
    <!-- Header -->
    <div class="qa-header">
        <h1>Quản lý Hỏi Đáp</h1>
        <p>Trả lời câu hỏi từ học viên của bạn</p>
    </div>

    <!-- Filters -->
    <div class="filter-section">
        <form method="GET" action="<?php echo e(route('admin.questions.index')); ?>">
            <div class="filter-group">
                <!-- Status Filter -->
                <div>
                    <label class="form-label">Trạng thái</label>
                    <select name="status" class="form-control">
                        <option value="">Tất cả</option>
                        <option value="pending" <?php echo e(request('status') === 'pending' ? 'selected' : ''); ?>>Chờ trả lời</option>
                        <option value="answered" <?php echo e(request('status') === 'answered' ? 'selected' : ''); ?>>Đã trả lời</option>
                        <option value="closed" <?php echo e(request('status') === 'closed' ? 'selected' : ''); ?>>Đã đóng</option>
                    </select>
                </div>

                <!-- Course Filter -->
                <div>
                    <label class="form-label">Khóa học</label>
                    <select name="course_id" class="form-control">
                        <option value="">Tất cả khóa học</option>
                        <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $courseItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($courseItem->id); ?>" <?php echo e(request('course_id') == $courseItem->id ? 'selected' : ''); ?>>
                                <?php echo e($courseItem->title); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <!-- Search -->
                <div>
                    <label class="form-label">Tìm kiếm</label>
                    <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Tiêu đề câu hỏi..." class="form-control">
                </div>

                <!-- Submit -->
                <div style="display: flex; align-items: flex-end;">
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-filter"></i> Lọc
                    </button>
                </div>
            </div>
        </form>
    </div>

    <?php if(session('success')): ?>
        <div class="alert-success">
            <i class="fas fa-check-circle"></i> <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <!-- Questions List -->
    <?php if($questions->count() > 0): ?>
        <div class="question-list">
            <?php $__currentLoopData = $questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="question-item" style="<?php echo e($loop->last ? 'border-bottom: none;' : ''); ?>">
                    <a href="<?php echo e(route('admin.questions.show', $question)); ?>" style="text-decoration: none; color: inherit; display: block;">
                        <div style="display: flex; gap: 16px;">
                            <!-- Stats -->
                            <div class="question-stats">
                                <div class="stat-box <?php echo e($question->answers_count > 0 ? 'answered' : ''); ?>">
                                    <div class="stat-number">
                                        <?php echo e($question->answers_count); ?>

                                    </div>
                                    <div class="stat-label">trả lời</div>
                                </div>
                            </div>

                            <!-- Content -->
                            <div style="flex: 1;">
                                <h3 class="question-title">
                                    <?php echo e($question->title); ?>

                                    <?php if($question->is_resolved): ?>
                                        <span class="badge-resolved">
                                            <i class="fas fa-check"></i> Resolved
                                        </span>
                                    <?php endif; ?>
                                </h3>
                                
                                <p class="question-excerpt">
                                    <?php echo e(Str::limit(strip_tags($question->content), 150)); ?>

                                </p>

                                <div class="question-meta">
                                    <span class="course-name"><?php echo e($question->course->title); ?></span>
                                    
                                    <?php if($question->lesson): ?>
                                        <span><i class="fas fa-play-circle"></i> <?php echo e($question->lesson->title); ?></span>
                                    <?php endif; ?>
                                    
                                    <span><i class="fas fa-user"></i> <?php echo e($question->user->name); ?></span>
                                    <span><i class="fas fa-clock"></i> <?php echo e($question->created_at->diffForHumans()); ?></span>
                                    
                                    <?php if($question->status === 'pending'): ?>
                                        <span class="badge-pending">
                                            <i class="fas fa-hourglass-half"></i> Chờ trả lời
                                        </span>
                                    <?php elseif($question->status === 'answered'): ?>
                                        <span class="badge-answered">
                                            <i class="fas fa-check"></i> Đã trả lời
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <!-- Pagination -->
        <div style="margin-top: 20px;">
            <?php echo e($questions->links()); ?>

        </div>
    <?php else: ?>
        <div class="empty-state">
            <i class="fas fa-inbox"></i>
            <h3>Không có câu hỏi nào</h3>
            <p>Chưa có học viên nào đặt câu hỏi.</p>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\elearning\resources\views/admin/instructor/questions/index.blade.php ENDPATH**/ ?>