<?php $__env->startSection('head'); ?>
    <style>
        .icon-bg{
            background: deepskyblue;
            width: auto;
            padding: 5px 10px;
            border-radius: 9px;
            display: inline-block;
        }

        .box-categories{
            background: aliceblue;
            margin: 10px 0px;
            border-radius: 5px;
            padding: 15px;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <div class="col-lg-12">
            <div class="card card-borderless">
                <div>
                    <div class="row m-3">
                        <div class="col-md-12">
                            <form action="<?php echo e(url('admin/static/save')); ?>" method="post" enctype="multipart/form-data"><?php echo csrf_field(); ?>
                                <div class="row column-seperation padding-5">

                                    <div class="col-md-12">
                                        Site Settings
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group form-group-default">
                                                    <label>Home banner title</label>
                                                    <input type="text" class="form-control" name="<?php echo e(('hb-banner-title')); ?>" placeholder="Enter title" value="<?php echo e(Key::get('hb-banner-title')); ?>">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group form-group-default">
                                                    <?php if(Key::get('site-logo-image') !== 'NA'): ?>

                                                        <img src="<?php echo e(Key::get('site-logo-image')); ?>" alt="" width="100%;">
                                                        - <a href="<?php echo e(url('admin/static/home/cmd/delete/'.encrypt('site-logo'))); ?>" >click here</a> to remove image
                                                    <?php endif; ?>
                                                    <label>Site Logo</label>
                                                    <input type="file" class="form-control" name="<?php echo e(('site-logo-image')); ?>" placeholder="Enter title">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group form-group-default">
                                                    <label>Site description</label>
                                                    <input type="text" class="form-control" name="<?php echo e(('site-description')); ?>" placeholder="Enter title" value="<?php echo e(Key::get('site-description')); ?>">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group form-group-default">
                                                    <label>Contact us</label>
                                                    <input type="text" class="form-control" name="<?php echo e(('site-contact-us')); ?>" placeholder="Enter title" value="<?php echo e(Key::get('site-contact-us')); ?>">
                                                </div>
                                            </div>


                                        </div>


                                    </div>




                                </div>
                                <button class="btn btn-success" type="submit">Update data</button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('bottom'); ?>
    ##parent-placeholder-c03e9099aad17cb58e4fff1d93d751105735c9c2##

    <script>
        $('.remove-item-popular').click(function () {
            confirm_alert('Are you sure ?','You are going to delete this category','redirect','<?php echo e(url('admin/static/home/popular/remove')); ?>/'+$(this).data('id'));
        });

    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.common.datatable', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\migas\resources\views/admin/static/site.blade.php ENDPATH**/ ?>