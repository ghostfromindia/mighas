<?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	<li <?php if($depth == 0): ?> class="nav-links__item <?php if(isset($item->children)): ?> nav-links__item--has-submenu <?php endif; ?>" <?php else: ?> class="nav-links__item menu__item" <?php endif; ?>>

		<?php if($depth == 0): ?>
			<a class="nav-links__item-link" href="<?php echo e($item->slug); ?>">
                <div class="nav-links__item-body">
                    <?php echo e(strtolower($item->title)); ?>

                    <?php if(isset($item->children)): ?>
                        <svg class="nav-links__item-arrow" width="9px" height="6px">
                            <use xlink:href="<?php echo e(URL::asset('client')); ?>/images/sprite.svg#arrow-rounded-down-9x6"></use>
                        </svg>
                    <?php endif; ?>
                </div>
            </a>
        <?php else: ?>
        	<div class="menu__item-submenu-offset"></div>
            <a class="menu__item-link" href="<?php echo e($item->slug); ?>">
                <?php echo e(strtolower($item->title)); ?>

                <?php if(isset($item->children)): ?>
	                <svg class="menu__item-arrow" width="6px" height="9px">
	                    <use xlink:href="<?php echo e(URL::asset('client')); ?>/images/sprite.svg#arrow-rounded-right-6x9"></use>
	                </svg>
	            <?php endif; ?>
            </a>
		<?php endif; ?>
        <?php if(isset($item->children)): ?>
        	<?php if($type == 1 && $depth == 0): ?>
        		<div class="nav-links__submenu nav-links__submenu--type--megamenu nav-links__submenu--size--nl">
                                        <!-- .megamenu -->
                                        <div class="megamenu ">
                                            <div class="megamenu__body">
                                                <div class="row">
                                                	<?php $__currentLoopData = $item->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$megamenu_root_child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                		<?php if($key == 0 || round(count($item->children)/2)== $key): ?>
                                                			<div class="col-6">
                                                				<ul class="megamenu__links megamenu__links--level--0">
                                                		<?php endif; ?>
                                                			<li class="megamenu__item  megamenu__item--with-submenu ">
                                                                <a href="<?php echo e($megamenu_root_child->slug); ?>"><?php echo e(strtolower($megamenu_root_child->title)); ?></a>
                                                                <?php if(isset($megamenu_root_child->children)): ?>
                                                                <ul class="megamenu__links megamenu__links--level--1">
                                                                	<?php $__currentLoopData = $megamenu_root_child->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $megamenu_child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    	<li class="megamenu__item"><a href="<?php echo e($megamenu_child->slug); ?>"><?php echo e($megamenu_child->title); ?></a></li>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                </ul>
                                                                <?php endif; ?>
                                                            </li>
                                                		<?php if($key+1 == count($item->children) || round(count($item->children)/2)== $key+1): ?>
                                                				</ul>
                                                			</div>
                                                		<?php endif; ?>
                                                	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- .megamenu / end -->
                                    </div>
        	<?php else: ?>
	        	<div <?php if($depth == 0): ?> class="nav-links__submenu nav-links__submenu--type--menu" <?php else: ?> class="menu__submenu" <?php endif; ?>>
	                <!-- .menu -->
	                <div class="menu menu--layout--classic ">
	                    <div class="menu__submenus-container"></div>
	                    <ul class="menu__list">
	                    	<?php echo $__env->make('client.includes.menu', ['items'=>$item->children, 'depth'=>++$depth, 'type'=>$type], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	                    </ul>
	                </div>
	            </div>
            <?php endif; ?>
        <?php endif; ?>
	<li>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH /home/works/public_html/hykon-beta/resources/views/client/includes/menu.blade.php ENDPATH**/ ?>