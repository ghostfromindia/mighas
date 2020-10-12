<?php if(isset($slug)): ?> <?php else: ?> <?php $slug = 'warranty'; ?> <?php endif; ?>
<?php $__env->startSection('title',Key::page_meta($slug,'title')); ?>
<?php $__env->startSection('meta_description',Key::page_meta($slug,'description')); ?>
<?php $__env->startSection('meta_keywords',Key::page_meta($slug,'keywords')); ?>
<?php $__env->startSection('extra_css',Key::page_meta($slug,'css')); ?>
<?php $__env->startSection('extra_js',Key::page_meta($slug,'js')); ?>
<?php $__env->startSection('content'); ?>
    <div class="site__body">
        <div class="  block m-0 ">
            <div class="row">
                <div class="col-12 col-lg-12  ">
                    <div class="block-slideshow__body ">
                        <div class="block-slideshow__slide  "  >
                            <?php if($page->banner_image): ?>
                            <img src="<?php echo e(asset($page->banner_image->file_path)); ?>" width="100%" />
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-header">
            <div class="page-header__container container  ">
                <div class="warranty-banner">
                    <h2><?php echo e($page->primary_heading); ?></h2>
                    <p><?php echo e($page->short_description); ?> </p>
                </div>


                <div class="block-finder__header text-left pt-0 warranty-form" style="margin-top: 120px;">
                    <div class="row mb-3">
                        <div class="col-xl-12">
                            <div class="block-finder__subtitle text-left ">
                                <h3>WARRANTY REGISTRATION</h3>
                                <p><?php echo $page->content; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            <form action="<?php echo e(url('company/warranty')); ?>" method="post" id="warranty-form"> <?php echo csrf_field(); ?>
                                <div class="form-row">
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="name" placeholder="Customer Name*" required>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control"  name="phone" placeholder="Mobile number" required>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="email"  placeholder="Email address*" required>
                                    </div>
                                </div>
                                <hr/>
                                <h4>BILLING ADDRESS</h4>
                                <div class="form-row">
                                    <div class="col-md-4">
                                        <input type="text" class="form-control"  name="address_1" placeholder="Building/Apartment Name*" required>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control"  name="address_2" placeholder="Block/Flat No*" required>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="street_1"  placeholder="Street/Road Name*" required>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="locality"  placeholder="Locality*" required>
                                </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="landmark"  placeholder="Landmark*" required>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="pincode"  placeholder="Pincode*" required>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-4">
                                        <select id="inputState" name="state" class="form-control" required>

                                            <option selected>State</option>
                                            <?php $__currentLoopData = $states; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $obj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($obj->id); ?>"><?php echo e($obj->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <select id="inputState" name="district" class="form-control" required>
                                            <option selected>District</option>
                                            <?php $__currentLoopData = $district; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $obj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($obj->id); ?>"><?php echo e($obj->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                                <hr/>
                                <div class=" row">
                                    <div class="col-md-6">
                                        <h4>INSTALLATION ADDRESS</h4>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="form-check ">
                                                <input class="form-check-input" type="checkbox" name="same" id="same">
                                                <label class="form-check-label" for="gridCheck">
                                                    Same as above
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-4">
                                        <input type="text" class="form-control"  name="address_1_1" placeholder="Building/Apartment Name*" required>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control"  name="address_2_1" placeholder="Block/Flat No*" required>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="street_1_1"  placeholder="Street/Road Name*" required>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="locality_1"  placeholder="Locality*" required>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="landmark_1"  placeholder="Landmark*" required>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="pincode_1"  placeholder="Pincode*" required>
                                    </div>
                                </div>
                                <div class="form-row" id="hide-same">
                                    <div class="col-md-4">
                                        <select id="inputState" name="state_1" class="form-control" required>

                                            <option selected>State</option>
                                            <?php $__currentLoopData = $states; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $obj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($obj->id); ?>"><?php echo e($obj->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <select id="inputState" name="district_1" class="form-control" required>
                                            <option selected>District</option>
                                            <?php $__currentLoopData = $district; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $obj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($obj->id); ?>"><?php echo e($obj->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                                <hr/>
                                <div class="form-row">
                                    <div class="col-md-4">
                                        <select id="inputState" name="type" class="form-control" required>
                                            <option selected>Product Type</option>
                                            <?php $__currentLoopData = $category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $obj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option><?php echo e($obj->category_name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4" style="display: none" id="pro_type">
                                        <input type="text" class="form-control" name="pro_type"  placeholder="Product Type" required>
                                    </div>
                                    <div class="col-md-4">
                                        <select id="inputState" name="model" class="form-control" required>
                                            <option selected>Model Number</option>
                                            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $obj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option><?php echo e($obj->product_name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4" style="display: none" id="pro_model">
                                        <input type="text" class="form-control" name="pro_model"  placeholder="Product model" required>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="serial_number" placeholder="Product Serial Number*" required>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="dealer"  placeholder="Dealer Name*" required>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="date" class="form-control" name="inst_date"  placeholder="Installation Date*" required>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="contact_person" placeholder="Contact Person" required>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">SUBMIT</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('bottom'); ?>

    <script>

        <?php if(session('success')): ?>
                Swal.fire(
                    'success!',
                    '<?php echo e(session('success')); ?>',
                    'success'
                )
        <?php endif; ?>
        $("#warranty-form").validate();


        $('#same').change(function () {
            if($("#same").is(':checked'))
                duplicate();  // checked
            else
               clear();  // unchecked
        })

        $('select[name=type]').change(function () {
            if($(this).val() == 'other'){
                $('#pro_type').show();
            }else{
                $('#pro_type').hide();
            }
        })
        $('select[name=model]').change(function () {
            if($(this).val() == 'other'){
                $('#pro_model').show();
            }else{
                $('#pro_model').hide();
            }
        })

        function clear(){
            $('input[name=address_1_1]').val('');
            $('input[name=address_2_1]').val('');
            $('input[name=street_1_1]').val('');
            $('input[name=locality_1]').val('');
            $('input[name=landmark_1]').val('');
            $('input[name=pincode_1]').val('');
            $('#hide-same').show();
        }

        function duplicate(){
            $('input[name=address_1_1]').val($('input[name=address_1]').val());
            $('input[name=address_2_1]').val($('input[name=address_2]').val());
            $('input[name=street_1_1]').val($('input[name=street_1]').val());
            $('input[name=locality_1]').val($('input[name=locality]').val());
            $('input[name=landmark_1]').val($('input[name=landmark]').val());
            $('input[name=pincode_1]').val($('input[name=pincode]').val());
            $('#hide-same').hide();
        }

        $('select[name=state]').change(function () {
            var state = $('select[name=state]').val();
            $.get('<?php echo e(url('/branch/states')); ?>/'+state+'?id=all').done(function (data) {
                data = JSON.parse(data)
                var op = '<option>Choose a district</option>';
                data.forEach(function (item) {
                    console.log(item.name)
                    op += '<option value="'+item.id+'">'+item.name+'</option>'
                })
                $('select[name=district]').html(op);
            });

        })

        $('select[name=state_1]').change(function () {
            var state = $('select[name=state_1]').val();
            $.get('<?php echo e(url('/branch/states')); ?>/'+state+'?id=all').done(function (data) {
                data = JSON.parse(data)
                var op = '<option>Choose a district</option>';
                data.forEach(function (item) {
                    console.log(item.name)
                    op += '<option value="'+item.id+'">'+item.name+'</option>'
                })
                $('select[name=district_1]').html(op);
            });

        })
    </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('hykon.layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\hykon\resources\views/hykon/pages/warranty.blade.php ENDPATH**/ ?>