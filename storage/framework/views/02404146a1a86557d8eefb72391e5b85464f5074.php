<?php $__currentLoopData = $files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	<div class="col-md-3 media-previe-wrap" >
		<div class="thumbnail text-center" style="">
			<?php if($file->media_type == "Image"): ?>
				<img src="<?php echo e(asset('public/'.$file->thumb_file_path)); ?>" class="checkable" id="<?php echo e($file->id); ?>" data-extra-attr="<?php echo e($holder_attr); ?>" data-original-src="<?php echo e(asset('public/'.$file->file_path)); ?>">
				
			<?php else: ?>
				<img src="<?php echo e(asset('public/'.$file->thumb_file_path)); ?>" class="icon checkable" id="<?php echo e($file->id); ?>" data-original-src="<?php echo e(asset('public/'.$file->file_path)); ?>" data-type="<?php echo e($file->file_type); ?>" data-extra-attr="<?php echo e($holder_attr); ?>">
				
			<?php endif; ?>
		</div>
	</div>
	<?php if(($key+1)%4 == 0): ?>
	<div class="clearfix"></div>
	<?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<div class="col-md-12 media-popup-nav text-right">
	<input type="hidden" id="currentPage" value="<?php echo e($page); ?>">
	<?php echo e($files->appends(['req' => $req])->links()); ?>

</div><?php /**PATH C:\xampp\htdocs\hykon\resources\views/admin/media/ajax_index_popup.blade.php ENDPATH**/ ?>