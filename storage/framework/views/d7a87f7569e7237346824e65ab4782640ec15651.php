<?php $__env->startSection('head'); ?>
    ##parent-placeholder-1a954628a960aaef81d7b2d4521929579f3541e6##
    <link rel="stylesheet" href="<?php echo e(asset('assets/plugins/cropper/css/cropper.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/plugins/cropper/css/main.css')); ?>">
    <style type="text/css">
        .img-container-edit img{
            max-width: 100%;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid">

        <div class="col-md-12" style="margin-bottom: 20px;" align="right">
            
            <span class="page-heading">HOME PAGE SETTINGS</span>
        </div>

        <div class="col-lg-12">
            <div class="card card-borderless">

                <form method="POST" action="<?php echo e(route('admin.home-settings.store')); ?>" class="p-t-15" id="ModelFrm" data-validate=true>
                <?php echo csrf_field(); ?>
                <input type="hidden" name="website_features_id" value="<?php echo e(encrypt($website_features->id)); ?>">
                <input type="hidden" name="banner_setting_id" value="<?php echo e(encrypt($banner->id)); ?>">
                <input type="hidden" name="featured_brands_setting_id" value="<?php echo e(encrypt($featured_brands->id)); ?>">
                <input type="hidden" name="contact_setting_id" value="<?php echo e(encrypt($contact->id)); ?>">
                <input type="hidden" name="social_media_setting_id" value="<?php echo e(encrypt($social_media->id)); ?>">
                <input type="hidden" name="footer_setting_id" value="<?php echo e(encrypt($footer->id)); ?>">
                <ul class="nav nav-tabs nav-tabs-simple d-none d-md-flex d-lg-flex d-xl-flex" role="tablist" data-init-reponsive-tabs="dropdownfx">

                    <li class="nav-item">
                        <a href="#" data-toggle="tab" role="tab"
                           data-target="#tab5"
                        class="" aria-selected="false">Social Media</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" data-toggle="tab" role="tab"
                           data-target="#tab6"
                        class="" aria-selected="false">Footer Links</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane" id="tab5">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default">
                                        <label>Title</label>
                                        <input type="text" name="social_media_title" class="form-control" value="<?php echo e($social_media_data->title); ?>" >
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default">
                                        <label>Facebook</label>
                                        <input type="text" name="social_media[facebook]" class="form-control" value="<?php echo e($social_media_data->social_media->facebook); ?>" >
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default">
                                        <label>Twitter</label>
                                        <input type="text" name="social_media[twitter]" class="form-control" value="<?php echo e($social_media_data->social_media->twitter); ?>" >
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default">
                                        <label>Instagram</label>
                                        <input type="text" name="social_media[instagram]" class="form-control" value="<?php echo e($social_media_data->social_media->instagram); ?>" >
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default">
                                        <label>LinkedIn</label>
                                        <input type="text" name="social_media[linkedin]" class="form-control" value="<?php echo e($social_media_data->social_media->linkedin); ?>" >
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default">
                                        <label>YouTube</label>
                                        <input type="text" name="social_media[youtube]" class="form-control" value="<?php echo e($social_media_data->social_media->youtube); ?>" >
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default">
                                        <label>Pinterest</label>
                                        <input type="text" name="social_media[pinterest]" class="form-control" value="<?php echo e($social_media_data->social_media->pinterest); ?>" >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                                <div class="col-md-12" align="right">
                                    <button type="submit" class="btn btn-primary" name="submit" value="social_media_save">Save</button>
                                </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab6">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default">
                                        <label>Title</label>
                                        <input type="text" name="footer_title" class="form-control" value="<?php echo e($footer_data->title); ?>" >
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row" id="box">
                                    <?php
                                        if(!empty($footer_data->content))
                                            $count = count($footer_data->content);
                                        else
                                            $count = 0;
                                    ?>

                                    <?php if(!empty($footer_data->content)): ?>
                                        <?php $__currentLoopData = $footer_data->content; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                                            <div class="row w-100 mb-2 descriptionwrapper" >
                                                <div class="col-md-5">
                                                    <div class="form-group ">
                                                        <label>Name</label>
                                                        <input type="text" name="footer_description[<?php echo e($key); ?>][name]" class="form-control" <?php if(isset($value)): ?> value="<?php echo e($value->name); ?>" <?php else: ?> value="" <?php endif; ?> required>
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="form-group ">
                                                        <label>Url</label>
                                                        <input type="text" name="footer_description[<?php echo e($key); ?>][url]" class="form-control" <?php if(isset($value)): ?> value="<?php echo e($value->url); ?>" <?php else: ?> value="" <?php endif; ?> required>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <button type="button" id="delete" class="btn btn-danger btn-sm remove" style="margin:29px;">Remove</button>
                                                </div>
                                            </div>                          
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>

                                    <div class="row w-100 mb-2 descriptionwrapper" >
                                        <div class="col-md-5">
                                            <div class="form-group ">
                                                <label>Name</label>
                                                <input type="text" name="footer_description[<?php echo e($count); ?>][name]" class="form-control"  >
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group ">
                                                <label>Url</label>
                                                <input type="text" name="footer_description[<?php echo e($count); ?>][url]" class="form-control"  >
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" name="add" id="add" class="btn btn-success" style="margin:29px;">Add More</button>
                                        </div>
                                    </div>                                          
                                </div>
                            </div>
                        </div>
                        <div class="row">
                                <div class="col-md-12" align="right">
                                    <button type="submit" class="btn btn-primary" name="submit" value="footer_save">Save</button>
                                </div>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('bottom'); ?>
    <script src="<?php echo e(asset('assets/plugins/cropper/js/common.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/plugins/cropper/js/cropper.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/plugins/cropper/js/jquery-cropper.js')); ?>"></script>

    <script type="text/javascript">
        $(function(){
            //banner image
            var $image = $('#banner-image');
            var ratio = $image.parent().attr('data-crop-ratio');
            var crop_data = $image.parent().attr('data-crop-details');

            var $dataX = $("#dataX"),
            $dataY = $("#dataY"),
            $dataHeight = $("#dataHeight"),
            $dataWidth = $("#dataWidth");
            $cropData = $('#cropData');

            var init_data = { x: parseFloat($dataX.val()), y: parseFloat($dataY.val()), width: parseFloat($dataWidth.val()), height: parseFloat($dataHeight.val()) }


            var options = {
                autoCrop: true,
                aspectRatio: parseFloat(1110/170),
                preview: '.img-preview-web',
                data: init_data,
                crop: function (e) {
                    $dataX.val(Math.round(e.detail.x));
                    $dataY.val(Math.round(e.detail.y));
                    $dataHeight.val(Math.round(e.detail.height));
                    $dataWidth.val(Math.round(e.detail.width));
                    $cropData.val(JSON.stringify(e.detail));
                }
            };
            var cropper = $image.cropper(options);

            $(document).on('click', '#setBannerImage', function(){
                var id = $('.imgChked').find('img').attr('id');
                var src = $('.imgChked').find('img').attr('data-original-src');
                var link = $('#banner-image').prop('src', src);
                $('#banner_id').val(id);
                $image.cropper("destroy");
                var cropper = $image.cropper(options);
                jconfirm.instances[0].close();
            });

            //mobile banner image

            var $image1 = $('#mobile-banner-image');
            var ratio1 = $image1.parent().attr('data-crop-ratio');
            var crop_data_mobile1 = $image1.parent().attr('data-crop-details');

            var $dataMX = $("#dataMX"),
            $dataMY = $("#dataMY"),
            $dataMHeight = $("#dataMHeight"),
            $dataMWidth = $("#dataMWidth");
            $cropMData = $('#cropMData');

            var init_data1 = { x: parseFloat($dataMX.val()), y: parseFloat($dataMY.val()), width: parseFloat($dataMWidth.val()), height: parseFloat($dataMHeight.val()) }


            var options1 = {
                autoCrop: true,
                aspectRatio: parseFloat(510/390),
                preview: '.img-preview-mob',
                data: init_data1,
                crop: function (e) {
                    $dataMX.val(Math.round(e.detail.x));
                    $dataMY.val(Math.round(e.detail.y));
                    $dataMHeight.val(Math.round(e.detail.height));
                    $dataMWidth.val(Math.round(e.detail.width));
                    $cropMData.val(JSON.stringify(e.detail));
                }
            };
            var cropper1 = $image1.cropper(options1);

            $(document).on('click', '#setMobileBannerImage', function(){
                var id = $('.imgChked').find('img').attr('id');
                var src = $('.imgChked').find('img').attr('data-original-src');
                var link = $('#mobile-banner-image').prop('src', src);
                $('#mobile_banner_id').val(id);
                $image1.cropper("destroy");
                var cropper1 = $image1.cropper(options1);
                jconfirm.instances[0].close();
            });

            var i = '<?php echo e($count); ?>';
       
            $("#add").click(function(){
                   
                i++;
           
                $("#box").append('<div class="row w-100 mb-2 descriptionwrapper" ><div class="col-md-5"><input type="text" name="footer_description['+i+'][name]" placeholder="Enter your Name" class="form-control" /></div><div class="col-md-5"><input type="text" name="footer_description['+i+'][url]" placeholder="Enter your url" class="form-control" /></div><div class="col-md-2"><button type="button" class="btn btn-danger btn-sm remove" >Remove</button></div></div>');
            });
           
            $(document).on('click', '.remove', function(){  
                 $(this).parents('.descriptionwrapper').remove();
            }); 
               $(document).on('click', '.delete', function(){  
                 $(this).parents('.delete').remove();
            });
        })
                                
    </script>
    ##parent-placeholder-c03e9099aad17cb58e4fff1d93d751105735c9c2##
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.common.fileupload', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\migas\resources\views/admin/home_settings/index.blade.php ENDPATH**/ ?>