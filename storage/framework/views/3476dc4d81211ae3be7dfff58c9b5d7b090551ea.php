<?php $__env->startSection('head'); ?>
<style type="text/css">
    .no-order-error {
        text-align: center;
        border: 1px solid #ddd;
        padding: 20px;
        color: red;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php
  $no_image = asset('images/no_image.jpeg');
?>
    <div class="page-header">
                <div class="page-header__container container">
                    <div class="page-header__breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="<?php echo e(url('/')); ?>">Home</a>
                                    <svg class="breadcrumb-arrow" width="6px" height="9px">
                                        <use xlink:href="<?php echo e(asset('client')); ?>/images/sprite.svg#arrow-rounded-right-6x9"></use>
                                    </svg>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="<?php echo e(url('account/dashboard')); ?>">My Account</a>
                                    <svg class="breadcrumb-arrow" width="6px" height="9px">
                                        <use xlink:href="<?php echo e(asset('client')); ?>/images/sprite.svg#arrow-rounded-right-6x9"></use>
                                    </svg>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">My Orders</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="page-header__title">
                        <h1>My Orders</h1>
                    </div>
                </div>
            </div>
            <div class="block">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-lg-3 d-flex">
                            <div class="account-nav flex-grow-1">
                                <h4 class="account-nav__title">Navigation</h4>
                                <?php echo $__env->make('client.includes.account_menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                        </div>
                        <div class="col-12 col-lg-9 mt-4 mt-lg-0">
                            <?php if(count($orders)>0): ?>
                                    <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="card mb-3">
                                            <div class="card-header p-2">
                                                  <a href="<?php echo e(url('account/order', [$order->order_reference_number])); ?>" class="btn btn-info"><?php echo e($order->order_reference_number); ?></a>
                                                
                                                <a href="<?php echo e(url('account/order', [$order->order_reference_number])); ?>" class="btn btn-sm btn-secondary float-right"><i class="fa fa-truck-moving"></i> Track</a>
                                                <a href="javascript:void()" class="btn btn-sm btn-secondary float-right"><i class="fa fa-money"></i> Payment mode : <?php echo e($order->payment_method); ?></a>
                                                <a href="javascript:void()" class="btn btn-sm btn-secondary float-right"><i class="fa fa-money"></i> Payment mode : <?php echo e($order->status); ?></a>
                                            </div>
                                            <div class="card-divider"></div>
                                            <div class="card-body p-2">
                                                <?php $__currentLoopData = $order->details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=> $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <div class="row m-2">
                                                        <div class="col-md-2 text-center">
                                                            <img src="<?php if($item->product_variants->image_id && $item->product_variants->media): ?> <?php echo e(asset('public/'.$item->product_variants->media->thumb_file_path)); ?> <?php else: ?> <?php echo e($no_image); ?> <?php endif; ?>" onerror="this.onerror=null;this.src='<?php echo e($no_image); ?>'" style="max-width:75px;">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <a href="<?php echo e(url($item->product_variants->slug)); ?>" class="text-dark"><?php echo e(str_limit($item->product_variants->name, $limit = 50, $end = '...')); ?></a>
                                                            <?php if($item->product_variants->attribute_level1): ?>
                                                                <p class="m-0">
                                                                    <small>
                                                                        <?php echo e($item->product_variants->attribute_level1->attribute->attribute_name); ?>: 
                                                                        <?php echo e($item->product_variants->attribute_level1->value); ?>

                                                                    </small>
                                                                </p>
                                                            <?php endif; ?>
                                                            <?php if($item->product_variants->attribute_level2): ?>
                                                                <p class="m-0">
                                                                    <small>
                                                                        <?php echo e($item->product_variants->attribute_level2->attribute->attribute_name); ?>: 
                                                                        <?php echo e($item->product_variants->attribute_level2->value); ?>

                                                                    </small>
                                                                </p>
                                                            <?php endif; ?>
                                                            <?php if($item->product_variants->attribute_level3): ?>
                                                                <p class="m-0">
                                                                    <small>
                                                                        <?php echo e($item->product_variants->attribute_level3->attribute->attribute_name); ?>: 
                                                                        <?php echo e($item->product_variants->attribute_level3->value); ?>

                                                                    </small>
                                                                </p>
                                                            <?php endif; ?>
                                                            <?php
                                                                $current_status = $item->tracking_history->where('order_status_labels_master_id', $item->status)->first()->notes;
                                                            ?>
                                                            <p class="m-0"><small>Quantity: <?php echo e($item->quantity); ?></small></p>
                                                            <?php if($item->ratings() != 0): ?>
                                                                <div class="my-rating" data-rating="<?php echo e($item->ratings()); ?>"></div>
                                                            <?php endif; ?>
                                                            


                                                        </div>
                                                        <div class="col-md-3">₹ <?php echo e(number_format($item->price, 2)); ?></div>
                                                        <div class="col-md-3">
                                                            <?php if($item->is_cancelled == 1): ?>
                                                                <span class="text-uppercase"><b>Cancelled</b></span>
                                                                <p><small><?php echo e($item->get_status_note()); ?></small></p>
                                                            <?php elseif($item->is_returned == 1): ?>
                                                                <span class="text-uppercase"><b>Returned</b></span>
                                                                <small><?php echo e($item->returned_reason); ?></small>
                                                            <?php else: ?>
                                                                <span class="text-uppercase"><b><?php echo e($item->tracking_status->name); ?></b></span>

                                                                <p><small><?php echo e($current_status); ?></small></p>
                                                            <?php endif; ?>
                                                            <?php if($item->is_cancelled == 2): ?>
                                                                <p><small class="text-danger">Requested for cancel</small></p>
                                                            <?php endif; ?>
                                                        </div>
                                                        <?php if($item->is_returned): ?>
                                                        <div></div>
                                                        <?php endif; ?>
                                                    </div>
                                                    <?php if(count($order->details) != $key+1): ?>
                                                        <div class="card-divider"></div>
                                                    <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                            <div class="card-divider"></div>
                                            <div class="card-footer row">
                                                <div class="col-md-6 text-left">Order Placed On : <span class="text-dark"><?php echo e(date('d M, Y h:i A', strtotime($order->created_at))); ?></span></div>
                                                <div class="col-md-6 text-right">Order Total : <span class="text-dark"><?php echo e(number_format($order->total_sale_price, 2)); ?></span></div>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                    <div class="no-order-error">No Orders Found</div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

<!-- The Modal -->
<div id="myModal" class="modal" ref="myModal">

    <!-- Modal content -->
    <div class="modal-content mc">
        <div  id="modalcontent">
        <span class="close" id="close" ref="close" style="float:right">&times;</span>
        <h3 class="block-header__title p_grad" style="font-size: 25px;">Please rate the product here</h3>
        <hr>
        <div class="my-rating" id="rate-ing"></div>
        <br>
        <label for="title">Please enter the review title</label>
        <input type="text" class="form-control" name="title" id="title"> <br>

        <label for="title">Please enter a description</label>
        <textarea type="text" class="form-control" name="description" id="description" rows="5"></textarea><br>

        <input type="hidden" id="order_id">
        <input type="hidden" id="rating">

        <button type="button" class="btn btn-dark" onclick="saveReview()">Rate</button>
        </div>

        <div id="modalloading" align="center">
            <img src="<?php echo e(asset('images/loading.svg')); ?>" alt="" id="modalloadinginner" style="display: none">
            <img src="<?php echo e(asset('images/success.png')); ?>" alt="" id="modalsuccess" width="100px" style="display: none">
        </div>

    </div>


</div>



<?php $__env->stopSection(); ?>
<?php $__env->startSection('bottom'); ?>
    <script src="<?php echo e(asset('client/js/jquery.star-rating-svg.js')); ?>"></script>
    <script>
        var Mcontent = $("#modalcontent");
        var MLoad = $("#modalloading");
        var Mloading = $("#modalloadinginner");
        var Msuccess = $("#modalsuccess");

        $("#rate-ing").starRating({
            starSize: 25,
            totalStars: 5,
            disableAfterRate:false,
            callback: function(currentRating, $el){
                console.log(currentRating)
                $("#rating").val(currentRating)
            }
        });

        var modal = $("#myModal");
        var span = $("#close");


        function adReview(id){
            $("#title").val('');$("#description").val('');$("#rating").val('');$("#rate-ing").starRating('setRating', 0                                                                              )
            $("#order_id").val(id);
            $.post(baseUrl+'/fetch/review',{_token:csrf,id:id}).done(function (data) {
                let obj = JSON.parse(data); console.log(obj)
                modal.attr('style','display:block');
                if(obj.status){
                    $("#title").val(obj.title);
                    $("#description").val(obj.description);
                    $("#rating").val(obj.rating);
                    $("#rate-ing").starRating('setRating', obj.rating)
                }
            })
        }

        function saveReview() {
            var title = $("#title").val();
            var description = $("#description").val();
            var rating = $("#rating").val();
            if(rating.length == 0){$('.my-rating').after('<span style="color:red;">Please select a rating</span>');return false;}
            if(title.length == 0){$('#title').after('<span style="color:red;">Please Enter a Review title</span>');return false;}
            if(description.length == 0){$('#description').after('<span style="color:red;">Please Enter a Review description</span>');return false;}
            Mcontent.hide();
            MLoad.show();Mloading.fadeIn();
            var id = $("#order_id").val();

            $.post(baseUrl+'/review',{_token:csrf,title:title,description:description,id:id,rating:rating}).done(function (data) {
                console.log(data)
                setTimeout(function () {
                    Mloading.hide();
                    Msuccess.fadeIn();
                },1000)
                setTimeout(function () {
                    modal.removeAttr('style').attr('style','display:none');
                    Msuccess.hide();
                    Mcontent.show();
                    MLoad.hide();
                    window.location.reload()
                },2000)

            })
        }

        span.click(function () {
            modal.removeAttr('style').attr('style','display:none');
        })
    </script>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('head'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('client/css/jquery.star-rating-svg.css')); ?>">
    <style>
        .mc{
            height: unset !important;
        }
    </style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('hykon.layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/works/public_html/hykon-beta/resources/views/hykon/orders/index.blade.php ENDPATH**/ ?>