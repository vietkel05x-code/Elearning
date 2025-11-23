<?php if($paginator->hasPages()): ?>
    <nav style="display:flex;justify-content:center;align-items:center;gap:8px;margin-top:32px">
        
        <?php if($paginator->onFirstPage()): ?>
            <span style="padding:10px 16px;background:#f3f4f6;color:#9ca3af;border-radius:8px;cursor:not-allowed;pointer-events:none">
                ← Trước
            </span>
        <?php else: ?>
            <a href="<?php echo e($paginator->previousPageUrl()); ?>" rel="prev" 
               style="padding:10px 16px;background:#fff;color:#333;border:1px solid #e5e7eb;border-radius:8px;text-decoration:none;transition:all 0.2s;font-weight:500"
               onmouseover="this.style.background='#f9fafb';this.style.borderColor='#a435f0'"
               onmouseout="this.style.background='#fff';this.style.borderColor='#e5e7eb'">
                ← Trước
            </a>
        <?php endif; ?>

        
        <div style="display:flex;gap:4px;align-items:center">
            <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                
                <?php if(is_string($element)): ?>
                    <span style="padding:10px;color:#9ca3af">...</span>
                <?php endif; ?>

                
                <?php if(is_array($element)): ?>
                    <?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($page == $paginator->currentPage()): ?>
                            <span style="padding:10px 16px;background:#a435f0;color:white;border-radius:8px;font-weight:600;min-width:40px;text-align:center">
                                <?php echo e($page); ?>

                            </span>
                        <?php else: ?>
                            <a href="<?php echo e($url); ?>" 
                               style="padding:10px 16px;background:#fff;color:#333;border:1px solid #e5e7eb;border-radius:8px;text-decoration:none;transition:all 0.2s;min-width:40px;text-align:center;display:inline-block"
                               onmouseover="this.style.background='#f9fafb';this.style.borderColor='#a435f0'"
                               onmouseout="this.style.background='#fff';this.style.borderColor='#e5e7eb'">
                                <?php echo e($page); ?>

                            </a>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        
        <?php if($paginator->hasMorePages()): ?>
            <a href="<?php echo e($paginator->nextPageUrl()); ?>" rel="next"
               style="padding:10px 16px;background:#fff;color:#333;border:1px solid #e5e7eb;border-radius:8px;text-decoration:none;transition:all 0.2s;font-weight:500"
               onmouseover="this.style.background='#f9fafb';this.style.borderColor='#a435f0'"
               onmouseout="this.style.background='#fff';this.style.borderColor='#e5e7eb'">
                Sau →
            </a>
        <?php else: ?>
            <span style="padding:10px 16px;background:#f3f4f6;color:#9ca3af;border-radius:8px;cursor:not-allowed;pointer-events:none">
                Sau →
            </span>
        <?php endif; ?>
    </nav>
<?php endif; ?>

<?php /**PATH D:\elearning\resources\views/vendor/pagination/custom.blade.php ENDPATH**/ ?>