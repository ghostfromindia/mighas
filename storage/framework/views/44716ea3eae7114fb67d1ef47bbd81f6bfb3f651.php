<div class="col-md-12">
    <?php if(session('success_log')): ?>
        <div class="alert alert-success" role="alert">
            <?php echo e(session('success_log')); ?>

        </div>
    <?php endif; ?>

    <?php if(session('error_log')): ?>
        <div class="alert alert-error" role="alert">
             <?php echo e(session('error_log')); ?>

        </div>
    <?php endif; ?>

            <?php if(session('waring_log')): ?>
                    <div class="alert alert-warning" role="alert">
                            <?php echo e(session('waring_log')); ?>

                    </div>
            <?php endif; ?>
</div><?php /**PATH /home/works/public_html/hykon-beta/resources/views/hykon/components/logs.blade.php ENDPATH**/ ?>