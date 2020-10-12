<?php if(count($photos)>0): ?>
	<?php $__currentLoopData = $photos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $photo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<div class="col-md-3 media-preview-wrap parent" style="background: #e8e9ea;margin: 5px 5px 10px 10px">
			<a href="<?php echo e(url('admin/banners/photo-edit', array('id'=>$photo->id, 'slider_id'=>$slider, 'type'=>$type))); ?>" class="open-ajax-popup" title="update Image Details" data-popup-size="xlarge"><img src="<?php echo e(asset('public/'.$photo->media->thumb_file_path)); ?>"></a>
			<a href="<?php echo e(url('admin/banners/photo-delete',['slider'=>$slider, 'media'=>$photo->id, 'type'=>$type])); ?>" class="btn btn-danger delete-btn slider-photo-delete">X</a>
		</div>
	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?><?php /**PATH C:\xampp\htdocs\migas\resources\views/admin/banners/ajax_photos.blade.php ENDPATH**/ ?>