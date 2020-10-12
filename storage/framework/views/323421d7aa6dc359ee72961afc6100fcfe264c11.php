<?php if(isset($menu_items)): ?>
<?php $__currentLoopData = $menu_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <li class="footer-links__item"><a href="<?php echo e($item->slug); ?>" class="footer-links__link"><?php echo e($item->title); ?></a></li>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?><?php /**PATH C:\xampp\htdocs\hykon\resources\views/widgets/bottom_menu.blade.php ENDPATH**/ ?>