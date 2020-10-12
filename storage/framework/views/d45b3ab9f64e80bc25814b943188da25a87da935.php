<?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	<li class="dd-item" data-id="<?php echo e($item->menu_nextable_id); ?>">
		<div class="dd-handle accord-header"><span class="menu-title"><?php echo e($item->title); ?></span><span class="pull-right fa fa-angle-down toggle-arraow dd-nodrag"></span></div>
		<div class="accord-content">
			<div class="form-group required">
				<label class="control-label" for="inputCode">Navigation Label</label>
				<input type="text" name="menu[<?php echo e($item->menu_nextable_id); ?>][text]" class="form-control menu-title-input" value="<?php echo e($item->title); ?>"/>
			</div>
			<?php if($item->menu_type == 'custom_link'): ?>
				<div class="form-group required">
					<label class="control-label" for="inputCode">Url</label>
					<input type="text" name="menu[<?php echo e($item->menu_nextable_id); ?>][url]" class="form-control" value="<?php echo e($item->url); ?>"/>
				</div>
				<div class="form-group required">
					<div class="checkbox">
						<input type="checkbox" name="menu[<?php echo e($item->menu_nextable_id); ?>][target_blank]" id="checkbox-<?php echo e($item->menu_nextable_id); ?>" <?php if($item->target_blank==1): ?> checked="checked" <?php endif; ?> /> <label for="checkbox-<?php echo e($item->menu_nextable_id); ?>"> New Window</label>
					</div>
				</div>
				<input type="hidden" name="menu[<?php echo e($item->menu_nextable_id); ?>][original_title]" value="<?php echo e($item->original_title); ?>"/>
			<?php else: ?>
				<input type="hidden" name="menu[<?php echo e($item->menu_nextable_id); ?>][id]" value="<?php echo e($item->linkable_id); ?>"/>
			<?php endif; ?>
			<input type="hidden" name="menu[<?php echo e($item->menu_nextable_id); ?>][menu_nextable_id]" value="<?php echo e($item->menu_nextable_id); ?>"/>
			<p class="menu-original-text"> Original: <?php if($item->menu_type == 'custom_link'): ?> <?php echo e($item->original_title); ?> <?php else: ?> <?php if($item->linkable): ?> <?php echo e($item->linkable->name); ?> <?php endif; ?> <?php endif; ?></p>
			<p><a href="javascript:void(0)" class="remove-menu">Remove</a></p>
		</div>
		<?php if(isset($item->children)): ?>
			<ol class="dd-list">
				<?php echo $__env->make('admin.menus.menu', ['items'=>$item->children], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	        </ol>
		<?php endif; ?>
	</li>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php /**PATH /home/works/public_html/hykon-beta/resources/views/admin/menus/menu.blade.php ENDPATH**/ ?>