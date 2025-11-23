

<?php $__env->startSection('title', 'Quản lý Hỏi Đáp'); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/qa.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="admin-page">
    <div class="admin-header">
        <h1>Quản lý Hỏi Đáp (Q&A)</h1>
        <p>Tổng quan và quản lý câu hỏi từ học viên</p>
    </div>

    <!-- Statistics -->
    <div class="stats-grid">
        <div class="stat-card stat-total">
            <div class="stat-value"><?php echo e($stats['total']); ?></div>
            <div class="stat-label">Tổng câu hỏi</div>
        </div>
        <div class="stat-card stat-pending">
            <div class="stat-value"><?php echo e($stats['pending']); ?></div>
            <div class="stat-label">Chờ trả lời</div>
        </div>
        <div class="stat-card stat-answered">
            <div class="stat-value"><?php echo e($stats['answered']); ?></div>
            <div class="stat-label">Đã trả lời</div>
        </div>
        <div class="stat-card stat-closed">
            <div class="stat-value"><?php echo e($stats['closed']); ?></div>
            <div class="stat-label">Đã đóng</div>
        </div>
    </div>

    <!-- Filters -->
    <div class="admin-card" style="margin-bottom: 20px;">
        <form method="GET" action="<?php echo e(route('admin.questions.index')); ?>">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">
                <div>
                    <label class="form-label">Trạng thái</label>
                    <select name="status" class="form-control">
                        <option value="">Tất cả</option>
                        <option value="pending" <?php echo e(request('status') === 'pending' ? 'selected' : ''); ?>>Chờ trả lời</option>
                        <option value="answered" <?php echo e(request('status') === 'answered' ? 'selected' : ''); ?>>Đã trả lời</option>
                        <option value="closed" <?php echo e(request('status') === 'closed' ? 'selected' : ''); ?>>Đã đóng</option>
                    </select>
                </div>

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

                <div>
                    <label class="form-label">Tìm kiếm</label>
                    <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Tiêu đề câu hỏi..." class="form-control">
                </div>

                <div style="display: flex; align-items: flex-end;">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter"></i> Lọc
                    </button>
                </div>
            </div>
        </form>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <!-- Questions Table -->
    <?php if($questions->count() > 0): ?>
        <div class="admin-card">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Câu hỏi</th>
                        <th>Khóa học</th>
                        <th>Người hỏi</th>
                        <th>Trạng thái</th>
                        <th>Trả lời</th>
                        <th>Ngày tạo</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($question->id); ?></td>
                            <td>
                                <a href="<?php echo e(route('admin.questions.show', $question)); ?>" class="question-link">
                                    <?php echo e(Str::limit($question->title, 50)); ?>

                                </a>
                                <?php if($question->is_resolved): ?>
                                    <span class="badge badge-success" style="margin-left: 6px;">Resolved</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo e($question->course->title); ?></td>
                            <td><?php echo e($question->user->name); ?></td>
                            <td>
                                <?php if($question->status === 'pending'): ?>
                                    <span class="badge badge-warning">Chờ trả lời</span>
                                <?php elseif($question->status === 'answered'): ?>
                                    <span class="badge badge-success">Đã trả lời</span>
                                <?php else: ?>
                                    <span class="badge badge-secondary">Đã đóng</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo e($question->answers_count); ?></td>
                            <td><?php echo e($question->created_at->format('d/m/Y')); ?></td>
                            <td>
                                <div style="display: flex; gap: 8px;">
                                    <a href="<?php echo e(route('admin.questions.show', $question)); ?>" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <form action="<?php echo e(route('admin.questions.destroy', $question)); ?>" method="POST" style="display: inline;" onsubmit="return confirm('Xóa câu hỏi này?')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>

            <div style="margin-top: 20px;">
                <?php echo e($questions->links()); ?>

            </div>
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

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\elearning\resources\views/admin/questions/index.blade.php ENDPATH**/ ?>