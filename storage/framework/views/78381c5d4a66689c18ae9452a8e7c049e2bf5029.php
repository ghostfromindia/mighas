<?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	<li <?php if($item->id == $parent): ?> class="open active" <?php elseif($cur_url == $item->slug): ?> class="active" <?php endif; ?>>
		<a href="<?php echo e(url($item->slug)); ?>"  class="detailed">
			<span class="title"><?php echo e($item->title); ?></span>
			<?php if(isset($item->children)): ?>
				<span class="arrow"></span>
			<?php endif; ?>
		</a>
		<span class="icon-thumbnail"><i class="<?php echo e($item->icon); ?>"></i></span>
		<?php if(isset($item->children)): ?>
			<ul class="sub-menu">
		    	<?php echo $__env->make('admin.partials.menu', ['items'=>$item->children, 'parent'=>$parent, 'cur_url'=>$cur_url], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		    </ul>
		<?php endif; ?>
	</li>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH /home/works/public_html/hykon-beta/resources/views/admin/partials/menu.blade.php ENDPATH**/ ?>