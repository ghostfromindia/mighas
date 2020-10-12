<?php $__env->startSection('content'); ?>
    <!-- site__body -->
    <div class="site__body">

        <div class="cart block">
            <div class="container">
                <div class="row">
                    <div class="col-12 mb-3">
                        <?php echo $__env->make('hykon.components.logs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>

                    <div class="col-12 col-lg-6 offset-lg-3 col-xl-6 offset-x6-3 mt-4 mt-lg-0">
                        <div class="card mb-0">
                            <form action="<?php echo e(url('checkout/payment/initiate')); ?>" method="post"><?php echo csrf_field(); ?>
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

                                <input type="hidden" name="address" value="<?php echo e(encrypt($address->id)); ?>">

                                <b>Payment Method</b> <br>
                                <label for="cod">
                                    <input type="radio" name="payment_method" value="cod" id="cod"> Cash on delivery
                                </label> <br>
                                <label for="online">
                                    <input type="radio" name="payment_method" value="online" id="online" checked> Online Payment
                                </label>

                            </div>

                                <button type="submit" class="btn btn-dark btn-block">Continue</button>
                            </form>
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

<?php $__env->stopSection(); ?>
<?php echo $__env->make('hykon.layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/works/public_html/hykon-beta/resources/views/hykon/pages/checkout/overview.blade.php ENDPATH**/ ?>