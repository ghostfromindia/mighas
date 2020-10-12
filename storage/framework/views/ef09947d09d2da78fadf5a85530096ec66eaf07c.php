<?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	<li class="mobile-links__item" data-collapse-item>
            <div class="mobile-links__item-title">
                <a href="<?php echo e($item->slug); ?>" class="mobile-links__item-link"><?php echo e(strtolower($item->title)); ?></a>
                <?php if(isset($item->children)): ?>
                <button class="mobile-links__item-toggle" type="button" data-collapse-trigger>
                    <svg class="mobile-links__item-arrow" width="12px" height="7px">
                        <use xlink:href="<?php echo e(URL::asset('client')); ?>/images/sprite.svg#arrow-rounded-down-12x7"></use>
                    </svg>
                    </svg>
                </button>
                <?php endif; ?>
            </div>
            <?php if(isset($item->children)): ?>
            <div class="mobile-links__item-sub-links" data-collapse-content>
                <ul class="mobile-links mobile-links--level--1">
                    <?php echo $__env->make('client.includes.mobile_display_menu', ['items'=>$item->children, 'depth'=>++$depth], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </ul>
            </div>
            <?php endif; ?>
        </li>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php /**PATH /home/works/public_html/hykon-beta/resources/views/client/includes/mobile_display_menu.blade.php ENDPATH**/ ?>