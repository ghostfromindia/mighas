<?php if($message = Session::get('success')): ?>
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <strong>Success:</strong> <?php echo e($message); ?>

    </div>
    <?php echo e(Session::forget('success')); ?>

<?php endif; ?>

<?php if($message = Session::get('error')): ?>
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <strong>Error:</strong> <?php echo e($message); ?>

    </div>
    <?php echo e(Session::forget('error')); ?>

<?php endif; ?>

<?php if($message = Session::get('warning')): ?>
    <div class="alert alert-warning alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <strong>Warning:</strong> <?php echo e($message); ?>

    </div>
    <?php echo e(Session::forget('warning')); ?>

<?php endif; ?>

<?php if($message = Session::get('info')): ?>
    <div class="alert alert-info alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <strong>FYI:</strong> <?php echo e($message); ?>

    </div>
    <?php echo e(Session::forget('info')); ?>

<?php endif; ?>

<?php if($errors->any()): ?>
    <div class="alert alert-danger alert-error alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <strong>Errors:</strong><br>
        <?php echo implode('<br>', $errors->all()); ?>

    </div>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\hykon\resources\views/admin/partials/notifications.blade.php ENDPATH**/ ?>