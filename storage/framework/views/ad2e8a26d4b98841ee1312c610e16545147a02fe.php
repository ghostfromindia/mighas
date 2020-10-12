<?php $__env->startSection('head'); ?>
    ##parent-placeholder-1a954628a960aaef81d7b2d4521929579f3541e6##
    <link rel="stylesheet" href="<?php echo e(asset('assets/plugins/cropper/css/cropper.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/plugins/cropper/css/main.css')); ?>">
    <style>
        .page-sidebar{
            z-index: 999 !important;
        }
        .thumbnail{
            background: #e8e9ea;margin: 5px 5px 10px 10px
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <div class="container">

            <div class="col-md-12 p-0"  align="right" style="margin-bottom: 20px; ">
              <span class="page-heading">Edit Banner <small style="    text-transform: none;
    font-size: 11px;">- <a href="<?php echo e(url('admin/banners')); ?>">Go back to banner list</a></small></span>
            </div>
            <!-- START card -->
            <div class="card card-borderless filter-wrap">
                <form method="POST" action="<?php echo e(route($route.'.update', [encrypt($obj->id)])); ?>" class="p-t-15" id="DealerFrm" data-validate=true>
                  <?php echo csrf_field(); ?>
                  <input type="hidden" name="id" <?php if($obj->id): ?> value="<?php echo e(encrypt($obj->id)); ?>" <?php endif; ?> id="inputId">
                <div class="row m-2">
                    <div class="col-md-6">
                        <div class="row column-seperation padding-5">
                            <div class="form-group form-group-default">
                                <label>Banner Name</label>
                                <input type="text" name="banner_name" class="form-control" value="<?php echo e($obj->banner_name); ?>" >
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row column-seperation padding-5">
                            <div class="form-group form-group-default">
                                <label>Banner Link</label>
                                <input type="text" name="link" class="form-control" value="<?php echo e($obj->link); ?>" >
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row column-seperation padding-5">
                            <div class="form-group form-group-default">
                                <label>Banner Title</label>
                                <input type="text" name="title" class="form-control" value="<?php echo e($obj->title); ?>" >
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row column-seperation padding-5">
                            <div class="form-group form-group-default">
                                <label>Width</label>
                                <input type="text" name="width" class="form-control" value="<?php echo e($obj->width); ?>" maxLength="4" >
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row column-seperation padding-5">
                            <div class="form-group form-group-default">
                                <label>Height</label>
                                <input type="text" name="height" class="form-control" value="<?php echo e($obj->height); ?>" maxLength="4" >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" align="right">
                            <a href="<?php echo e(url('admin/media/popup', ['popup_type'=>'banners-'.$obj->id, 'type'=>'Image'])); ?>" class="open-ajax-popup btn btn-primary" title="Media Images" data-popup-size="large"><i class="glyphicon glyphicon-plus-sign"></i> Add Photos</a>

                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="<?php echo e(url('admin/banners')); ?>" class="btn btn-default">Cancel</a>
                        </div>
                    </div>
                </div>
                </form>
            </div>
            <div class="card card-borderless padding-15">
                    <div class="row" id="photoList">
                        <?php echo $__env->make('admin.banners.ajax_photos', ['photos'=>$obj->photos, 'slider'=>$obj->id, 'type'=>$type], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
            </div>
            <!-- END card -->
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('bottom'); ?>

    <script src="<?php echo e(asset('assets/plugins/cropper/js/common.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/plugins/cropper/js/cropper.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/plugins/cropper/js/jquery-cropper.js')); ?>"></script>
    ##parent-placeholder-c03e9099aad17cb58e4fff1d93d751105735c9c2##
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.common.fileupload', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\migas\resources\views/admin/banners/form.blade.php ENDPATH**/ ?>