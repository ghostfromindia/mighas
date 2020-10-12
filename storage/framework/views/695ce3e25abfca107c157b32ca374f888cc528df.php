<?php $__env->startSection('content'); ?>
    <!-- site__body -->
    <div class="site__body">
        <div class="page-header">
            <div class="page-header__container container">
                <div class="page-header__breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="<?php echo e(url('/')); ?>">Home</a>
                                <svg class="breadcrumb-arrow" width="6px" height="9px">
                                    <use xlink:href="<?php echo e(asset('hykon-ui')); ?>/images/sprite.svg#arrow-rounded-right-6x9"></use>
                                </svg>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Choose your address</li>
                        </ol>
                    </nav>
                </div>
                <div class="page-header__title">
                    <h1>Address</h1>
                </div>
            </div>
        </div>

        <div class="cart block">
            <div class="container">
                <div class="row">
                    <div class="col-12 mb-3">
                        <div class="alert alert-lg alert-primary">Please add your delivery address in order to proceed checkout  </div>
                        <?php echo $__env->make('hykon.components.logs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>


                        <div class="col-12 col-lg-6 col-xl-7">
                            <div class="card mb-lg-0">
                                <div class="card-body">

                                    <div class="payment-methods">
                                        <?php if(count($address) > 0): ?>
                                            <form action="<?php echo e(url('checkout/summary')); ?>" method="post"> <?php echo csrf_field(); ?>
                                                <h4>Choose your address</h4>
                                                <hr>
                                                    <div class="row">
                                                            <?php $__currentLoopData = $address; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $obj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <div class="col-md-4 p-0">
                                                                    <label for="address-<?php echo e($obj->id); ?>">
                                                                        <div class="border-ui">
                                                                            <input type="radio" name="address" id="address-<?php echo e($obj->id); ?>"
                                                                                   value="<?php echo e(encrypt($obj->id)); ?>" <?php if($obj->is_default == 1): ?> checked="true" <?php endif; ?> required>
                                                                            <b><?php echo e($obj->full_name); ?> (<?php echo e($obj->mobile_number); ?>)</b> <br>
                                                                            <?php echo e($obj->address1); ?><br>
                                                                            <?php echo e($obj->address2); ?><br>
                                                                            <?php echo e($obj->landmark); ?><br>
                                                                            <?php echo e($obj->city); ?><br>
                                                                            <?php echo e($obj->pincode); ?> <br>
                                                                        </div>
                                                                    </label>
                                                                </div>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </div>
                                                <div class="container-fluid" align="center">
                                                    <button type="submit" class="btn btn-dark">Continue to checkout</button>
                                                </div>
                                                <br>
                                            </form>
                                        <?php endif; ?>

                                        <a href="javascipt:void(0)" class="new-address">Add new address</a>
                                    </div>

                                    <div id="new-address" <?php if(count($address) == 0): ?> <?php else: ?> style="display: none" <?php endif; ?>>
                                        <form action="<?php echo e(url('checkout/address/save')); ?>" id="AddressFrmm" method="post" class="form-horizontal style-form" enctype="multipart/form-data">
                                            <?php echo csrf_field(); ?>

                                            <input type="hidden" name="location" value="">

                                            <div class="form-group">
                                                <label>Full Name</label>
                                                <input type="text" class="form-control" name="full_name" id="full_name" value="" placeholder="Enter your full name">
                                                <span id="full_name_error"></span>
                                            </div>
                                            <div class="form-group">
                                                <label>Mobile Number</label>
                                                <input type="text" class="form-control" name="mobile_number" id="mobile_number" placeholder="10 digit mobile number without prefix" maxlength="10" value="">
                                                <span id="mobile_number_error"></span>
                                            </div>
                                            <div class="form-group">
                                                <label>Pincode</label>
                                                <input type="text" class="form-control" name="pincode" placeholder="6 digit pincode" maxlength="6" value="">
                                                <span id="pincode_error"></span>
                                            </div>

                                            <div class="form-group">
                                                <label>Address</label>
                                                <input type="text" class="form-control" name="address1" placeholder="Flat / House No. / Floor / Building" value="">
                                                <span id="address1_error"></span>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="address2" placeholder="Colony / Street / Locality" value="">
                                            </div>
                                            <div class="form-group">
                                                <label>Landmark</label>
                                                <input type="text" class="form-control" name="landmark" placeholder="Eg: Near SBI Palarivattom" value="">
                                            </div>
                                            <div class="form-group">
                                                <label>City</label>
                                                <input type="text" class="form-control" name="city" value="">
                                                <span id="city_error"></span>
                                            </div>
                                            <div class="form-group">
                                                <label>State</label>
                                                <select class="form-control select2_input" data-placeholder="Select State" data-select2-url="<?php echo e(url('select2/state', [101])); ?>" name="state" id="state" >

                                                </select>
                                                <span id="state_error"></span>
                                            </div>
                                            <div class="form-group">
                                                <label>Address Type</label>
                                                <select class="form-control select2_input w-100" data-placeholder="Select Address Type" name="type" id="type" >
                                                    <option value="1" >Home</option>
                                                    <option value="0">Office</option>
                                                </select>
                                                <span id="type_error"></span>
                                            </div>
                                            <div class="form-group">
                                                <button class="btn btn-primary" type="submit" id="address-save-btn">Save</button>
                                            </div>
                                        </form>
                                    </div>




                                
                            </div>

                                <div class="card-divider"></div> 




                            </div>

                          
                        </div>




                    <div class="col-12 col-lg-6 col-xl-5 mt-4 mt-lg-0">
   <div class="card mb-0">
      <div class="card-body">
         <h3 class="card-title">Your Order</h3>
         <table class="checkout__totals">
            <thead class="checkout__totals-header">
               <tr>
                  <th>Product</th>
                  <th>Total</th>
               </tr>
            </thead>
            <tbody class="checkout__totals-products">
            <?php $total = 0; ?>
            <?php $__currentLoopData = $cart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $obj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php $total = $total + ($obj->quantity*$obj->price); ?>
               <tr>
                  <td><?php echo e($obj->product->name); ?> × <?php echo e($obj->quantity); ?></td>
                  <td><?php echo e($obj->quantity*$obj->price); ?></td>
               </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
            <tbody class="checkout__totals-subtotals">
               <tr>
                  <th>Subtotal</th>
                  <td>₹<?php echo e(number_format($total)); ?></td>
               </tr>
            </tbody>
            <tfoot class="checkout__totals-footer">
               <tr>
                  <th>Total</th>
                  <td>₹<?php echo e(number_format($total)); ?></td>
               </tr>
            </tfoot>
         </table>

      </div>
   </div>
</div>












                </div>
            </div>
        </div>

    </div>
    <!-- site__body / end -->
    <!-- site__body / end -->
    <div class="block call-action">
        <div class="container">
            <div class="d-flex justify-content-center">
                <h3>HAVE QUESTIONS?</h3>
                <a>Get In Touch</a>

            </div>


        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('head'); ?>
    <style>
        .form-group{
            margin-bottom: 0px;
            margin-top: 10px;
        }
        .error{
            color:red;
        }
        .border-ui{
            border: 1px dotted #b5b5b5;
            padding: 5px;
            margin: 5px;
            border-radius: 5px;

        }
    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('bottom'); ?>
    <script src="<?php echo e(url('js/spiderworks.js')); ?>"></script>
    <script>
        $('.new-address').click(function () {
            $('#new-address').fadeIn();
        })
        $('#AddressFrmm').validate({
            rules:
                {
                    full_name: "required",
                    mobile_number: {
                        required : true,
                        digits  : true,
                    },
                    pincode: {
                        required : true,
                        digits  : true,
                    },
                    address1: "required",
                    city: "required",
                    state: "required",
                    type: "required",
                },
            messages:
                {
                    full_name: "Name cannot be blank",
                    mobile_number: {
                        required: "Mobile number cannot be blank",
                    },
                    pincode: {
                        required: "Pincode cannot be blank",
                    },
                    address1: "Address cannot be blank",
                    city: "City cannot be blank",
                    state: "Select a state",
                    type: "Select an address type",
                },
            errorPlacement: function (error, element) {
                error.insertAfter($(element).parent('div'));
            }
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('hykon.layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/works/public_html/hykon-beta/resources/views/hykon/pages/checkout/address.blade.php ENDPATH**/ ?>