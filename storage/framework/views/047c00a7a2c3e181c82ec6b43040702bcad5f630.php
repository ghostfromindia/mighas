<?php $__currentLoopData = $menu_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mMenu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	<?php echo $__env->make('client.includes.menu', ['items'=>$mMenu['menu'], 'depth'=>0, 'type'=>$mMenu['type']], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php /**PATH /home/works/public_html/hykon-beta/resources/views/widgets/main_menu.blade.php ENDPATH**/ ?>