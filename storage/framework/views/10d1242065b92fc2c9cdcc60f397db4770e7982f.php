<?php $__env->startSection('head'); ?>
    ##parent-placeholder-1a954628a960aaef81d7b2d4521929579f3541e6##
    <!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/plugins/fileupload/css/jquery.fileupload.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/plugins/fileupload/css/jquery.fileupload-ui.css')); ?>">
    <!-- CSS adjustments for browsers with JavaScript disabled -->
    <noscript><link rel="stylesheet" href="<?php echo e(asset('public/assets/plugins/fileupload/css/jquery.fileupload-noscript.css')); ?>"></noscript>
    <noscript><link rel="stylesheet" href="<?php echo e(asset('public/assets/plugins/fileupload/css/jquery.fileupload-ui-noscript.css')); ?>"></noscript>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('bottom'); ?>
    ##parent-placeholder-c03e9099aad17cb58e4fff1d93d751105735c9c2##
    <!-- The Load Image plugin is included for the preview images and image resizing functionality -->
    <script src="<?php echo e(asset('public/assets/plugins/fileupload/js/load-image.all.min.js')); ?>"></script> 
    <!-- The Canvas to Blob plugin is included for image resizing functionality -->
    <script src="<?php echo e(asset('public/assets/plugins/fileupload/js/canvas-to-blob.min.js')); ?>"></script>
    <!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
    <script src="<?php echo e(asset('public/assets/plugins/fileupload/js/jquery.iframe-transport.js')); ?>"></script>
    <!-- The basic File Upload plugin -->
    <script src="<?php echo e(asset('public/assets/plugins/fileupload/js/jquery.fileupload.js')); ?>"></script>
    <!-- The File Upload processing plugin -->
    <script src="<?php echo e(asset('public/assets/plugins/fileupload/js/jquery.fileupload-process.js')); ?>"></script>
    <!-- The File Upload image preview & resize plugin -->
    <script src="<?php echo e(asset('public/assets/plugins/fileupload/js/jquery.fileupload-image.js')); ?>"></script>
    <!-- The File Upload audio preview plugin -->
    <script src="<?php echo e(asset('public/assets/plugins/fileupload/js/jquery.fileupload-audio.js')); ?>"></script>
    <!-- The File Upload video preview plugin -->
    <script src="<?php echo e(asset('public/assets/plugins/fileupload/js/jquery.fileupload-video.js')); ?>"></script>
    <!-- The File Upload validation plugin -->
    <script src="<?php echo e(asset('public/assets/plugins/fileupload/js/jquery.fileupload-validate.js')); ?>"></script>
    <!-- The File Upload user interface plugin -->
    <script src="<?php echo e(asset('public/assets/plugins/fileupload/js/jquery.fileupload-ui.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.common.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\migas\resources\views/admin/common/fileupload.blade.php ENDPATH**/ ?>