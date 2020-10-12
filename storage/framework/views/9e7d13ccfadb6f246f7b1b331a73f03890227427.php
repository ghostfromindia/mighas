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
                        <div class="col-md-6">
                                    <div class="row column-seperation padding-5">


                                        <div class="col-md-12 box-categories">
                                            <form action="<?php echo e(url('admin/static/home/popular')); ?>" method="post">
                                                <?php echo csrf_field(); ?>
                                            Popular Categories
                                            <hr>
                                            <div class="form-group form-group-default">
                                                <label>Add <b>Popular right now</b> categories</label>
                                                <select data-placeholder="Choose categories" multiple data-init-plugin="select2" data-select2-url="<?php echo e(url('select2/categories')); ?>" class="full-width select2_input" id="categories" name="categories[]"></select>
                                                <button class="btn btn-success" style="margin-top: 10px;" type="submit">Update popular categories</button>

                                                <hr>

                                            </div>
                                                Popular categories already added listed below <br>
                                                <ul>
                                                    <?php $__currentLoopData = $popular_categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $obj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <li><?php echo e($obj->category_name); ?> - <a href="javascript:void(0)" class="remove-item-popular" data-model="<?php echo e(encrypt('Settings')); ?>" data-id="<?php echo e(encrypt($obj->id)); ?>">remove</a> </li>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </ul>
                                            </form>

                                        </div>


                                        <div class="col-md-12 box-categories">
                                            <form action="<?php echo e(url('admin/static/home/domestic')); ?>" method="post">
                                                <?php echo csrf_field(); ?>
                                                Domestic Categories
                                                <hr>
                                                <div class="form-group form-group-default">
                                                    <label>Add <b>Domestic</b> categories</label>
                                                    <select data-placeholder="Choose categories" multiple data-init-plugin="select2" data-select2-url="<?php echo e(url('select2/categories')); ?>" class="full-width select2_input" id="categories" name="categories[]"></select>
                                                    <button class="btn btn-success" style="margin-top: 10px;" type="submit">Update Domestic categories</button>

                                                    <hr>

                                                </div>
                                                Domestic categories already added listed below <br>
                                                <ul>
                                                    <?php $__currentLoopData = $domestic_categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $obj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <li><?php echo e($obj->category_name); ?> - <a href="javascript:void(0)" class="remove-item-domestic" data-model="<?php echo e(encrypt('Settings')); ?>" data-id="<?php echo e(encrypt($obj->id)); ?>">remove</a> </li>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </ul>
                                            </form>

                                        </div>



                                        <div class="col-md-12 box-categories">
                                            <form action="<?php echo e(url('admin/static/home/corporate')); ?>" method="post">
                                                <?php echo csrf_field(); ?>
                                                Corporate Categories
                                                <hr>
                                                <div class="form-group form-group-default">
                                                    <label>Add <b>Corporate</b> categories</label>
                                                    <select data-placeholder="Choose categories" multiple data-init-plugin="select2" data-select2-url="<?php echo e(url('select2/categories')); ?>" class="full-width select2_input" id="categories" name="categories[]"></select>
                                                    <button class="btn btn-success" style="margin-top: 10px;" type="submit">Update Corporate categories</button>

                                                    <hr>

                                                </div>
                                                Corporate categories already added listed below <br>
                                                <ul>
                                                    <?php $__currentLoopData = $corporate_categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $obj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <li><?php echo e($obj->category_name); ?> - <a href="javascript:void(0)" class="remove-item-corporate" data-model="<?php echo e(encrypt('Settings')); ?>" data-id="<?php echo e(encrypt($obj->id)); ?>">remove</a> </li>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </ul>
                                            </form>

                                        </div>


                                        <div class="col-md-12">
                                            <form action="<?php echo e(url('admin/static/home/cmd')); ?>" method="post" enctype="multipart/form-data">
                                                <?php echo csrf_field(); ?>
                                                CMD's Message
                                                <hr>
                                                <div class="form-group form-group-default">
                                                    <label>Title</label>
                                                    <input type="text" class="form-control" name="cmd_title" placeholder="Enter title" value="<?php echo e(Key::get('cmd-message-title')); ?>">
                                                </div>
                                                <div class="form-group form-group-default">
                                                    <label>Summary</label>
                                                    <textarea type="text" class="form-control" name="cmd_summary" placeholder="Enter summary"><?php echo e(Key::get('cmd-message-description')); ?></textarea>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group form-group-default">
                                                            <label>Start Up</label>
                                                            <input type="text" class="form-control" name="cmd_start_up" placeholder="Eg. 10" value="<?php echo e(Key::get('start-up')); ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group form-group-default">
                                                            <label>Employees</label>
                                                            <input type="text" class="form-control" name="cmd_employess" placeholder="Eg. 10" value="<?php echo e(Key::get('employees')); ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group form-group-default">
                                                            <label>Companies</label>
                                                            <input type="text" class="form-control" name="cmd_companies" placeholder="Eg. 10" value="<?php echo e(Key::get('companies')); ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group form-group-default">
                                                            <label>Crore Turnover</label>
                                                            <input type="text" class="form-control" name="cmd_crore_turnover" placeholder="Eg. 10" value="<?php echo e(Key::get('crore-turnover')); ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <?php if(Key::get('cmd-image') !== 'NA'): ?>
                                                            <img src="<?php echo e(Key::get('cmd-image')); ?>" alt="" width="100px;">
                                                            - <a href="<?php echo e(url('admin/static/home/cmd/delete/'.encrypt('cmd-image'))); ?>" >click here</a> to remove image
                                                        <?php endif; ?>
                                                        <div class="form-group form-group-default">
                                                            <label>CMD's Image</label>
                                                            <input type="file" class="form-control" name="cmd_image" placeholder="Eg. 10">
                                                        </div>
                                                    </div>
                                                </div>
                                                <button class="btn btn-success" style="margin-top: 10px;" type="submit">Update CMD's Message</button>
                                            </form>
                                        </div>

                                </div>

                        </div>
                        <div class="col-md-6">
                            <form action="<?php echo e(url('admin/static/home/highlights')); ?>" method="post" enctype="multipart/form-data"><?php echo csrf_field(); ?>
                            <div class="row column-seperation padding-5">
                                <div class="col-md-12">
                                Highlighting points
                                <hr>
                                <div class="form-group form-group-default">
                                    <label>Title</label>
                                    <input type="text" class="form-control" name="hl_title" placeholder="Enter title" value="<?php echo e(Key::get('hl-title')); ?>">
                                </div>
                                <div class="form-group form-group-default">
                                    <label>Summary</label>
                                    <textarea type="text" class="form-control" name="hl_summary" placeholder="Enter summary"><?php echo e(Key::get('hl-description')); ?></textarea>
                                </div>


                                </div>

                                <div class="col-md-6">

                                    <div style="width: 100%;padding: 5px;">Block 1</div>

                                    <div class="form-group form-group-default">
                                        <label>Title</label>
                                        <input type="text" class="form-control" name="b1_title" placeholder="Enter title" value="<?php echo e(Key::get('hl-s1-title')); ?>">
                                    </div>
                                    <div class="form-group form-group-default">
                                        <label>Summary</label>
                                        <textarea type="text" class="form-control" name="b1_summary" placeholder="Enter summary"><?php echo e(Key::get('hl-s1-summary')); ?></textarea>
                                    </div>

                                    <?php if(Key::get('hl-s1-icon') !== 'NA'): ?>
                                        <div class="icon-bg">
                                        <img src="<?php echo e(Key::get('hl-s1-icon')); ?>" alt="" width="20px;"> </div>
                                        - <a href="<?php echo e(url('admin/static/home/cmd/delete/'.encrypt('hl-s1-icon'))); ?>" >click here</a> to remove image
                                    <?php endif; ?>

                                    <div class="form-group form-group-default">
                                        <label>Icon</label>
                                        <input type="file" class="form-control" name="b1_icon" placeholder="Enter title">
                                    </div>

                                </div>
                                <div class="col-md-6">

                                    <div style="width: 100%;padding: 5px;">Block 2</div>

                                    <div class="form-group form-group-default">
                                        <label>Title</label>
                                        <input type="text" class="form-control" name="b2_title" placeholder="Enter title" value="<?php echo e(Key::get('hl-s2-title')); ?>">
                                    </div>
                                    <div class="form-group form-group-default">
                                        <label>Summary</label>
                                        <textarea type="text" class="form-control" name="b2_summary" placeholder="Enter summary"><?php echo e(Key::get('hl-s2-summary')); ?></textarea>
                                    </div>

                                    <?php if(Key::get('hl-s2-icon') !== 'NA'): ?>
                                        <div class="icon-bg">
                                            <img src="<?php echo e(Key::get('hl-s2-icon')); ?>" alt="" width="20px;"> </div>
                                        - <a href="<?php echo e(url('admin/static/home/cmd/delete/'.encrypt('hl-s2-icon'))); ?>" >click here</a> to remove image
                                    <?php endif; ?>

                                    <div class="form-group form-group-default">
                                        <label>Icon</label>
                                        <input type="file" class="form-control" name="b2_icon" placeholder="Enter title">
                                    </div>

                                </div>
                                <div class="col-md-6">

                                    <div style="width: 100%;padding: 5px;">Block 3</div>

                                    <div class="form-group form-group-default">
                                        <label>Title</label>
                                        <input type="text" class="form-control" name="b3_title" placeholder="Enter title" value="<?php echo e(Key::get('hl-s3-title')); ?>">
                                    </div>
                                    <div class="form-group form-group-default">
                                        <label>Summary</label>
                                        <textarea type="text" class="form-control" name="b3_summary" placeholder="Enter summary"><?php echo e(Key::get('hl-s3-summary')); ?></textarea>
                                    </div>

                                    <?php if(Key::get('hl-s3-icon') !== 'NA'): ?>
                                        <div class="icon-bg">
                                            <img src="<?php echo e(Key::get('hl-s3-icon')); ?>" alt="" width="20px;"> </div>
                                        - <a href="<?php echo e(url('admin/static/home/cmd/delete/'.encrypt('hl-s3-icon'))); ?>" >click here</a> to remove image
                                    <?php endif; ?>

                                    <div class="form-group form-group-default">
                                        <label>Icon</label>
                                        <input type="file" class="form-control" name="b3_icon" placeholder="Enter title">
                                    </div>

                                </div>
                                <div class="col-md-6">

                                    <div style="width: 100%;padding: 5px;">Block 4</div>

                                    <div class="form-group form-group-default">
                                        <label>Title</label>
                                        <input type="text" class="form-control" name="b4_title" placeholder="Enter title" value="<?php echo e(Key::get('hl-s4-title')); ?>">
                                    </div>
                                    <div class="form-group form-group-default">
                                        <label>Summary</label>
                                        <textarea type="text" class="form-control" name="b4_summary" placeholder="Enter summary" ><?php echo e(Key::get('hl-s4-summary')); ?></textarea>
                                    </div>

                                    <?php if(Key::get('hl-s4-icon') !== 'NA'): ?>
                                        <div class="icon-bg">
                                            <img src="<?php echo e(Key::get('hl-s4-icon')); ?>" alt="" width="20px;"> </div>
                                        - <a href="<?php echo e(url('admin/static/home/cmd/delete/'.encrypt('hl-s4-icon'))); ?>" >click here</a> to remove image
                                    <?php endif; ?>

                                    <div class="form-group form-group-default">
                                        <label>Icon</label>
                                        <input type="file" class="form-control" name="b4_icon" placeholder="Enter title">
                                    </div>



                                </div>


                            </div>
                            <button class="btn btn-success" type="submit">Update Highlighting points</button>
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
<?php echo $__env->make('admin.common.datatable', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/works/public_html/hykon-beta/resources/views/admin/static/home.blade.php ENDPATH**/ ?>