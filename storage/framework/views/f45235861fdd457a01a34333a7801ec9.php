<?php ($lastIndex = count($items) - 1); ?>
<nav class="breadcrumb" aria-label="Breadcrumb">
  <ol class="breadcrumb__list">
    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <li class="breadcrumb__item">
        <?php if(!empty($item['url']) && $index !== $lastIndex): ?>
          <a href="<?php echo e($item['url']); ?>" class="breadcrumb__link"><?php echo e($item['label']); ?></a>
        <?php else: ?>
          <span class="breadcrumb__current"><?php echo e($item['label']); ?></span>
        <?php endif; ?>
        <?php if($index !== $lastIndex): ?>
          <span class="breadcrumb__separator">/</span>
        <?php endif; ?>
      </li>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </ol>
</nav>
<?php $__env->startPush('styles'); ?>
<style>
  .breadcrumb {line-height:1.4; }
  .breadcrumb__list { list-style:none; margin:0; padding:0; display:flex; flex-wrap:nowrap; align-items:center; gap:.5rem; }
  .breadcrumb__item { display:inline-flex; align-items:center; white-space:nowrap; }
  .breadcrumb__item:last-child .breadcrumb__separator { display:none; }
  .breadcrumb__separator { margin:0 .25rem; color:#999; }
  .breadcrumb__link { color: var(--color-primary,#2563eb); text-decoration:none; }
  .breadcrumb__link:hover { text-decoration:underline; }
  .breadcrumb__separator { margin:0 .5rem; color:#999; }
  .breadcrumb__current { color:#555; font-weight:500; }
</style>
<?php $__env->stopPush(); ?><?php /**PATH D:\elearning\resources\views/components/breadcrumb.blade.php ENDPATH**/ ?>