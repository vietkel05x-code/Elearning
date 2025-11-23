

<?php $__env->startSection('title', 'Trang chủ'); ?>

<?php $__env->startSection('content'); ?>
<?php $__env->startPush('styles'); ?>
<style>
    .courses-row{display:grid;grid-template-columns:repeat(auto-fill,minmax(240px,1fr));gap:16px}
    .course-tile{display:block;background:#fff;border:1px solid var(--color-border,#e5e7eb);border-radius:10px;overflow:hidden;transition:transform .2s,box-shadow .2s;color:inherit;text-decoration:none}
    .course-tile:hover{transform:translateY(-2px);box-shadow:0 8px 24px rgba(0,0,0,.06)}
    .course-tile__thumb{aspect-ratio:16/9;background:#f0f0f0}
    .course-tile__thumb img{width:100%;height:100%;object-fit:cover;display:block}
    .course-tile__body{padding:12px 14px}
    .course-tile__title{font-weight:600;line-height:1.3;height:2.6em;overflow:hidden;margin-bottom:6px}
    .course-tile__meta{font-size:13px;color:#6b7280;display:flex;gap:6px;align-items:center;margin-bottom:8px}
    .course-tile__price{display:flex;gap:8px;align-items:baseline}
    .course-tile__price .current{font-weight:700}
    .course-tile__price .old{text-decoration:line-through;color:#9ca3af;font-size:13px}
    .course-tile__price .free{color:var(--color-success,#10b981);font-weight:700}
</style>
<?php $__env->stopPush(); ?>
<!-- HERO SECTION -->
<section class="hero">
    <div class="hero-content">
        <h2>Bắt đầu hành trình học tập với chi phí<span> tiết kiệm!</span></h2>
        <p>Nếu bạn mới bắt đầu với E-Learning, tin vui cho bạn đây! Trong thời gian có hạn, các khóa học chỉ từ <strong>279,000đ</strong> dành cho học viên mới. Đăng ký ngay hôm nay!</p>
        <div class="hero-cta">
            <a href="<?php echo e(route('courses.index')); ?>" class="cta-primary">Khám phá khóa học</a>
            <a href="<?php echo e(route('register')); ?>" class="cta-secondary">Đăng ký miễn phí</a>
        </div>
    </div>
    <div class="hero-stats">
        <div class="stat-item">
            <div class="stat-number" data-count="<?php echo e(\App\Models\Course::where('status', 'published')->count()); ?>">0</div>
            <div class="stat-label">Khóa học</div>
        </div>
        <div class="stat-item">
            <div class="stat-number" data-count="<?php echo e(\App\Models\User::where('role', 'student')->count()); ?>">0</div>
            <div class="stat-label">Học viên</div>
        </div>
        <div class="stat-item">
            <div class="stat-number" data-count="<?php echo e(\App\Models\Enrollment::where('status', 'active')->count()); ?>">0</div>
            <div class="stat-label">Lượt đăng ký</div>
        </div>
    </div>
</section>

<!-- CATEGORY SECTION -->
<section class="category-section">
  <div class="category-left">
    <h2>Trang bị các kỹ năng quan trọng cho công việc và cuộc sống.</h2>
    <p>E-Learning giúp bạn rèn luyện nhanh các kỹ năng được nhà tuyển dụng tìm kiếm và nâng tầm sự nghiệp trong bối cảnh thị trường lao động luôn biến động.</p>
  </div>

  <div class="category-right">
    <div class="category-carousel-wrapper">
        <div class="category-carousel">
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="category-card">
                    <img src="<?php echo e(asset('img/categories/' . ($cat->thumbnail->path ?? 'default.jpg'))); ?>" alt="<?php echo e($cat->name); ?>">
                    <div class="category-info">
                        <h4><?php echo e($cat->name); ?></h4>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

    <div class="carousel-dots">
        <span class="dot active" data-index="0"></span>
        <span class="dot" data-index="1"></span>
        <span class="dot" data-index="2"></span>
    </div>
  </div>
</section>


<!-- ================= COURSES BY CATEGORY (TABS) ================= -->
<div class="page-wrapper">

    <section class="tab-section">
        <h2>Kỹ năng giúp bạn bứt phá trong sự nghiệp và cuộc sống.</h2>
        <p>Dù là kỹ năng thiết yếu hay kiến thức kỹ thuật chuyên sâu, E-Learning luôn hỗ trợ bạn phát triển sự nghiệp bền vững.</p>

        <div class="tab-header">
            <?php $__currentLoopData = $topCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="tab-link <?php echo e($index === 0 ? 'active' : ''); ?>" data-id="<?php echo e($category->id); ?>">
                    <?php echo e($category->name); ?>

                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div class="tab-content">
            <?php $__currentLoopData = $topCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="tab-panel <?php echo e($index === 0 ? 'active' : ''); ?>" id="tab-<?php echo e($category->id); ?>">
                    <div class="course-slider">
                        <button class="arrow prev">&#10094;</button>
                        <div class="course-grid">
                            <?php $__currentLoopData = $coursesByCategory[$category->id]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="course-card">
                                <img src="<?php echo e(asset('img/courses/' . ($course->thumbnail_path ?? 'default.jpg'))); ?>" alt="<?php echo e($course->title); ?>">
                                <h4><?php echo e($course->title); ?></h4>
                                <p class="instructor"><?php echo e($course->instructor->name ?? 'Instructor'); ?></p>
                                <div class="price">
                                    <span class="new">₫<?php echo e(number_format($course->price, 0, ',', '.')); ?></span>
                                    <?php if($course->compare_at_price): ?>
                                    <span class="old">₫<?php echo e(number_format($course->compare_at_price, 0, ',', '.')); ?></span>
                                    <?php endif; ?>
                                </div>

                                <!-- Popup -->
                                <div class="course-popup">
                                    <h4><?php echo e($course->title); ?></h4>
                                    <span class="badge">Bestseller</span>
                                    <p class="meta">
                                        <?php echo e($course->formatted_total_duration); ?> · <?php echo e(ucfirst($course->level)); ?> · <?php echo e(ucfirst($course->language)); ?>

                                    </p>
                                    <p class="desc"><?php echo e($course->short_description); ?></p>
                                    <ul>
                                        <li>Understand key concepts and build solid foundations</li>
                                        <li>Hands-on lessons and real projects</li>
                                        <li>Updated to latest version in 2025</li>
                                    </ul>
                                    <button class="add-cart-btn">Add to cart</button>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div> <!-- course-grid -->
                        <button class="arrow next">&#10095;</button>
                    </div> <!-- course-slider -->

                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </section>
</div>

<!-- STATS SECTION -->
<section class="stats-section">
    <div class="page-wrapper">
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <h3>Học mọi lúc mọi nơi</h3>
                <p>Truy cập khóa học từ bất kỳ thiết bị nào, học theo tốc độ của riêng bạn</p>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-certificate"></i>
                </div>
                <h3>Chứng chỉ hoàn thành</h3>
                <p>Nhận chứng chỉ sau khi hoàn thành khóa học để nâng cao sự nghiệp</p>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h3>Cộng đồng học tập</h3>
                <p>Kết nối với hàng nghìn học viên và giảng viên trên toàn thế giới</p>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-headset"></i>
                </div>
                <h3>Hỗ trợ 24/7</h3>
                <p>Đội ngũ hỗ trợ luôn sẵn sàng giúp đỡ bạn trong suốt quá trình học tập</p>
            </div>
        </div>
    </div>
</section>

<!-- TRENDING COURSES (DB only) -->
<?php if(isset($trendingCourses) && $trendingCourses->count()): ?>
<section class="trending-section">
    <div class="page-wrapper">
        <div style="display:flex;align-items:flex-end;justify-content:space-between;margin-bottom:16px;gap:12px;flex-wrap:wrap">
            <h2 style="margin:0;font-size:28px;font-weight:700">Khóa học thịnh hành</h2>
            <a href="<?php echo e(route('courses.index', ['sort' => 'students'])); ?>" class="cta-secondary">Xem tất cả</a>
        </div>
        <div class="courses-row">
            <?php $__currentLoopData = $trendingCourses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a class="course-tile" href="<?php echo e(route('courses.show', $course->slug)); ?>">
                <div class="course-tile__thumb">
                    <img src="<?php echo e($course->thumbnail_url); ?>" alt="<?php echo e($course->title); ?>">
                </div>
                <div class="course-tile__body">
                    <div class="course-tile__title"><?php echo e($course->title); ?></div>
                    <div class="course-tile__meta">
                        <span><?php echo e(number_format($course->rating, 1)); ?> ★ (<?php echo e($course->rating_count); ?>)</span>
                        <span>·</span>
                        <span><?php echo e($course->enrolled_students); ?> học viên</span>
                    </div>
                    <div class="course-tile__price">
                        <?php if($course->price == 0): ?>
                            <span class="free">Miễn phí</span>
                        <?php else: ?>
                            <span class="current">₫<?php echo e(number_format($course->price, 0, ',', '.')); ?></span>
                            <?php if($course->compare_at_price): ?>
                                <span class="old">₫<?php echo e(number_format($course->compare_at_price, 0, ',', '.')); ?></span>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- NEWEST COURSES (DB only) -->
<?php if(isset($newestCourses) && $newestCourses->count()): ?>
<section class="newest-section">
    <div class="page-wrapper">
        <div style="display:flex;align-items:flex-end;justify-content:space-between;margin-bottom:16px;gap:12px;flex-wrap:wrap">
            <h2 style="margin:0;font-size:28px;font-weight:700">Khóa học mới nhất</h2>
            <a href="<?php echo e(route('courses.index', ['sort' => 'latest'])); ?>" class="cta-secondary">Xem tất cả</a>
        </div>
        <div class="courses-row">
            <?php $__currentLoopData = $newestCourses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a class="course-tile" href="<?php echo e(route('courses.show', $course->slug)); ?>">
                <div class="course-tile__thumb">
                    <img src="<?php echo e($course->thumbnail_url); ?>" alt="<?php echo e($course->title); ?>">
                </div>
                <div class="course-tile__body">
                    <div class="course-tile__title"><?php echo e($course->title); ?></div>
                    <div class="course-tile__meta">
                        <span><?php echo e(number_format($course->rating, 1)); ?> ★ (<?php echo e($course->rating_count); ?>)</span>
                        <span>·</span>
                        <span><?php echo e($course->formatted_total_duration); ?></span>
                    </div>
                    <div class="course-tile__price">
                        <?php if($course->price == 0): ?>
                            <span class="free">Miễn phí</span>
                        <?php else: ?>
                            <span class="current">₫<?php echo e(number_format($course->price, 0, ',', '.')); ?></span>
                            <?php if($course->compare_at_price): ?>
                                <span class="old">₫<?php echo e(number_format($course->compare_at_price, 0, ',', '.')); ?></span>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- REVIEWS FROM DB (no fake) -->
<?php if(isset($latestReviews) && $latestReviews->count()): ?>
<section class="testimonials-section">
    <div class="page-wrapper">
        <h2 style="text-align:center;margin-bottom:48px;font-size:32px;font-weight:700">Nhận xét mới nhất</h2>
        <div class="testimonials-grid">
            <?php $__currentLoopData = $latestReviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="testimonial-card">
                <div class="testimonial-rating">
                    <?php for($i=1;$i<=5;$i++): ?>
                        <i class="fas fa-star<?php echo e($i <= (int)$review->rating ? '' : '-o'); ?>"></i>
                    <?php endfor; ?>
                </div>
                <p class="testimonial-text"><?php echo e(\Illuminate\Support\Str::limit($review->content, 180)); ?></p>
                <div class="testimonial-author">
                    <div class="author-avatar">
                        <?php echo e(strtoupper(substr($review->user->name ?? 'U',0,1))); ?>

                    </div>
                    <div class="author-info">
                        <div class="author-name"><?php echo e($review->user->name ?? 'Người dùng'); ?></div>
                        <div class="author-role">Khoá: <?php echo e($review->course->title ?? ''); ?></div>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\elearning\resources\views/home.blade.php ENDPATH**/ ?>