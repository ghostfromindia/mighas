<ul class="menu-items">
	<?php echo $__env->make('admin.partials.menu', ['items'=>$menu_items, 'parent' => $parent, 'cur_url'=>$cur_url], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</ul><?php /**PATH /home/works/public_html/hykon-beta/resources/views/widgets/admin_menu.blade.php ENDPATH**/ ?>