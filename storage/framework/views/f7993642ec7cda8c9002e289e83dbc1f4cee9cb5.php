<?php if(count($photos)>0): ?>
	<?php $__currentLoopData = $photos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $photo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<div class="col-md-3 media-preview-wrap parent">
			<a href="<?php echo e(url('admin/sliders/photo-edit', array('id'=>$photo->id, 'slider_id'=>$slider, 'type'=>$type))); ?>" class="open-ajax-popup" title="update Image Details" data-popup-size="xlarge"><img src="<?php echo e(asset('public/'.$photo->media->thumb_file_path)); ?>"></a>
			<a href="<?php echo e(url('admin/sliders/photo-delete',['slider'=>$slider, 'media'=>$photo->id, 'type'=>$type])); ?>" class="btn btn-danger delete-btn slider-photo-delete">X</a>
		</div>
	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?><?php /**PATH /home/works/public_html/hykon-beta/resources/views/admin/sliders/ajax_photos.blade.php ENDPATH**/ ?>