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
            <div class="card card-borderless" style="padding: 10px">
                <h4>Quick links</h4>
                <ul>
                    <li><a href="<?php echo e(url('admin/menus/edit/'.encrypt(9))); ?>}"> Edit main menu</a></li>
                </ul>

            </div>
        </div>
        <div class="col-lg-12">
            <div class="card card-borderless">
                <div>
                    <div class="row m-3">
                        <div class="col-md-12">
                            <form action="<?php echo e(url('admin/static/home/highlights')); ?>" method="post" enctype="multipart/form-data"><?php echo csrf_field(); ?>
                            <div class="row column-seperation padding-5">

                                <div class="col-md-12">
                                Home page banners
                                <hr>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group form-group-default">
                                                <label>Link</label>
                                                <input type="text" class="form-control" name="<?php echo e(('hb-banner-title')); ?>" placeholder="Enter title" value="<?php echo e(Key::get('hb-banner-title')); ?>">
                                            </div>
                                        </div>
                                        <?php for($i=0;$i<9;$i++): ?>
                                            <div class="col-md-2">
                                            <?php if(Key::get('hb-banner-'.($i+1).'-image') !== 'NA'): ?>

                                                    <img src="<?php echo e(Key::get('hb-banner-'.($i+1).'-image')); ?>" alt="" width="100%;">
                                                - <a href="<?php echo e(url('admin/static/home/cmd/delete/'.encrypt('hb-banner-'.($i+1).'-image'))); ?>" >click here</a> to remove image
                                            <?php endif; ?>
                                            </div>


                                        <div class="col-md-5">
                                            <div class="form-group form-group-default">
                                                <label>Banner Image <?php echo e(($i+1)); ?></label>
                                                <input type="file" class="form-control" name="<?php echo e(('hb-banner-'.($i+1).'-image')); ?>" placeholder="Enter title">
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group form-group-default">
                                                <label>Link</label>
                                                <input type="text" class="form-control" name="<?php echo e(('hb-banner-'.($i+1).'-link')); ?>" placeholder="Enter title" value="<?php echo e(Key::get('hb-banner-'.($i+1).'-link')); ?>">
                                            </div>

                                        </div>
                                        <?php endfor; ?>
                                    </div>


                                </div>




                            </div>
                            <button class="btn btn-success" type="submit">Update Banners</button>
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
        $('.remove-item-domestic').click(function () {
            confirm_alert('Are you sure ?','You are going to delete this category','redirect','<?php echo e(url('admin/static/home/domestic/remove')); ?>/'+$(this).data('id'));
        });
        $('.remove-item-corporate').click(function () {
            confirm_alert('Are you sure ?','You are going to delete this category','redirect','<?php echo e(url('admin/static/home/corporate/remove')); ?>/'+$(this).data('id'));
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.common.datatable', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\migas\resources\views/admin/static/home.blade.php ENDPATH**/ ?>