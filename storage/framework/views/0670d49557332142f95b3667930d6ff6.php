

<?php $__env->startSection('title', 'Khóa học'); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/pages/courses.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<?php
  $breadcrumbItems = [
    ['label' => 'Trang chủ', 'url' => route('home')],
    ['label' => 'Khóa học']
  ];
?>
<?php echo $__env->make('components.breadcrumb', ['items' => $breadcrumbItems], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<section class="courses-page">
  <h1 class="courses-page__title">Khóa học</h1>

  <div class="courses-grid">
    <!-- Sidebar Filters -->
    <aside class="courses-filters">
      <form method="GET" action="<?php echo e(route('courses.index')); ?>" id="filterForm">
        <input type="hidden" name="search" value="<?php echo e(request('search')); ?>">

        <!-- Category Filter -->
        <div class="courses-filter">
          <h3 class="courses-filter__title">Danh mục</h3>
          <div class="courses-filter__options">
            <label class="courses-filter__option">
              <input type="radio" name="category" value="" <?php echo e(!request('category') ? 'checked' : ''); ?> onchange="document.getElementById('filterForm').submit()">
              <span>Tất cả</span>
            </label>
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <label class="courses-filter__option">
                <input type="radio" name="category" value="<?php echo e($category->id); ?>" <?php echo e(request('category') == $category->id ? 'checked' : ''); ?> onchange="document.getElementById('filterForm').submit()">
                <span><?php echo e($category->name); ?></span>
              </label>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </div>
        </div>

        <!-- Level Filter -->
        <div class="courses-filter">
          <h3 class="courses-filter__title">Cấp độ</h3>
          <div class="courses-filter__options">
            <label class="courses-filter__option">
              <input type="radio" name="level" value="" <?php echo e(!request('level') ? 'checked' : ''); ?> onchange="document.getElementById('filterForm').submit()">
              <span>Tất cả</span>
            </label>
            <label class="courses-filter__option">
              <input type="radio" name="level" value="beginner" <?php echo e(request('level') == 'beginner' ? 'checked' : ''); ?> onchange="document.getElementById('filterForm').submit()">
              <span>Cơ bản</span>
            </label>
            <label class="courses-filter__option">
              <input type="radio" name="level" value="intermediate" <?php echo e(request('level') == 'intermediate' ? 'checked' : ''); ?> onchange="document.getElementById('filterForm').submit()">
              <span>Trung bình</span>
            </label>
            <label class="courses-filter__option">
              <input type="radio" name="level" value="advanced" <?php echo e(request('level') == 'advanced' ? 'checked' : ''); ?> onchange="document.getElementById('filterForm').submit()">
              <span>Nâng cao</span>
            </label>
          </div>
        </div>

        <!-- Price Filter -->
        <div class="courses-filter">
          <h3 class="courses-filter__title">Giá</h3>
          <div class="courses-filter__options">
            <label class="courses-filter__option">
              <input type="radio" name="price_range" value="" <?php echo e(!request('price_range') ? 'checked' : ''); ?> onchange="updatePriceFilter('')">
              <span>Tất cả</span>
            </label>
            <label class="courses-filter__option">
              <input type="radio" name="price_range" value="free" <?php echo e(request('price_range') == 'free' ? 'checked' : ''); ?> onchange="updatePriceFilter('free')">
              <span>Miễn phí</span>
            </label>
            <label class="courses-filter__option">
              <input type="radio" name="price_range" value="0-500000" <?php echo e(request('price_range') == '0-500000' ? 'checked' : ''); ?> onchange="updatePriceFilter('0-500000')">
              <span>Dưới 500,000đ</span>
            </label>
            <label class="courses-filter__option">
              <input type="radio" name="price_range" value="500000-1000000" <?php echo e(request('price_range') == '500000-1000000' ? 'checked' : ''); ?> onchange="updatePriceFilter('500000-1000000')">
              <span>500,000đ - 1,000,000đ</span>
            </label>
            <label class="courses-filter__option">
              <input type="radio" name="price_range" value="1000000" <?php echo e(request('price_range') == '1000000' ? 'checked' : ''); ?> onchange="updatePriceFilter('1000000')">
              <span>Trên 1,000,000đ</span>
            </label>
          </div>
        </div>

        <!-- Sort -->
        <div class="courses-filter">
          <h3 class="courses-filter__title">Sắp xếp</h3>
          <select name="sort" onchange="document.getElementById('filterForm').submit()" class="courses-filter__select">
            <option value="latest" <?php echo e(request('sort') == 'latest' ? 'selected' : ''); ?>>Mới nhất</option>
            <option value="rating" <?php echo e(request('sort') == 'rating' ? 'selected' : ''); ?>>Đánh giá cao</option>
            <option value="students" <?php echo e(request('sort') == 'students' ? 'selected' : ''); ?>>Nhiều học viên</option>
            <option value="price_low" <?php echo e(request('sort') == 'price_low' ? 'selected' : ''); ?>>Giá thấp đến cao</option>
            <option value="price_high" <?php echo e(request('sort') == 'price_high' ? 'selected' : ''); ?>>Giá cao đến thấp</option>
          </select>
        </div>
      </form>
    </aside>

    <!-- Course List -->
    <main class="courses-list">
      <?php if($courses->count() > 0): ?>
        <div class="courses-grid-view">
          <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="course-card">
              <a href="<?php echo e(route('courses.show', $course->slug)); ?>">
                <img src="<?php echo e($course->thumbnail_url); ?>" alt="<?php echo e($course->title); ?>" 
                     class="course-card__image">
              </a>
              
              <div class="course-card__content">
                <h3 class="course-card__title">
                  <a href="<?php echo e(route('courses.show', $course->slug)); ?>" class="course-card__title-link">
                    <?php echo e($course->title); ?>

                  </a>
                </h3>
                <p class="course-card__instructor"><?php echo e($course->instructor->name ?? 'Instructor'); ?></p>
                
                <div class="course-card__rating">
                  <span class="course-card__rating-score"><?php echo e(number_format($course->rating, 1)); ?></span>
                  <div class="course-card__rating-stars">
                    <?php for($i = 0; $i < 5; $i++): ?>
                      <i class="fa fa-star<?php echo e($i < floor($course->rating) ? '' : '-o'); ?>"></i>
                    <?php endfor; ?>
                  </div>
                  <span class="course-card__rating-count">(<?php echo e($course->rating_count); ?>)</span>
                </div>

                <div class="course-card__price">
                  <?php if($course->price == 0): ?>
                    <span class="course-card__price-current" style="color: var(--color-success); font-weight: bold;">
                      Miễn phí
                    </span>
                  <?php else: ?>
                    <span class="course-card__price-current">
                      ₫<?php echo e(number_format($course->price, 0, ',', '.')); ?>

                    </span>
                    <?php if($course->compare_at_price): ?>
                      <span class="course-card__price-old">
                        ₫<?php echo e(number_format($course->compare_at_price, 0, ',', '.')); ?>

                      </span>
                    <?php endif; ?>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div style="margin-top: var(--spacing-xl);">
          <?php echo e($courses->links('vendor.pagination.custom')); ?>

        </div>
      <?php else: ?>
        <div class="courses-empty">
          <p class="courses-empty__message">Không tìm thấy khóa học nào</p>
          <a href="<?php echo e(route('courses.index')); ?>" class="btn btn--primary">
            Xem tất cả khóa học
          </a>
        </div>
      <?php endif; ?>
    </main>
  </div>
</section>

<script>
function updatePriceFilter(range) {
  const form = document.getElementById('filterForm');
  if (range === '') {
    form.price_min.value = '';
    form.price_max.value = '';
  } else if (range === 'free') {
    form.price_min.value = '0';
    form.price_max.value = '0';
  } else if (range === '0-500000') {
    form.price_min.value = '0';
    form.price_max.value = '500000';
  } else if (range === '500000-1000000') {
    form.price_min.value = '500000';
    form.price_max.value = '1000000';
  } else if (range === '1000000') {
    form.price_min.value = '1000000';
    form.price_max.value = '';
  }
  form.submit();
}

document.addEventListener('DOMContentLoaded', function() {
  const form = document.getElementById('filterForm');
  const priceMin = document.createElement('input');
  priceMin.type = 'hidden';
  priceMin.name = 'price_min';
  priceMin.value = '<?php echo e(request("price_min")); ?>';
  form.appendChild(priceMin);
  
  const priceMax = document.createElement('input');
  priceMax.type = 'hidden';
  priceMax.name = 'price_max';
  priceMax.value = '<?php echo e(request("price_max")); ?>';
  form.appendChild(priceMax);
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\elearning\resources\views/courses/index.blade.php ENDPATH**/ ?>