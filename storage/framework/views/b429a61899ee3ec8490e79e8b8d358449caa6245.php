<?php $__env->startSection('head'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/progress-tracker.css')); ?>">
    <style type="text/css">
        .display_notes{
            border: 1px solid #dad7d7;
        }

        .progress-step {
            flex: 1 1 11%;
        }


        .progress-text {
            margin-left: -21px !important;

        }
        .cancel-display{
            margin: 30px 0;
            text-align: center;
        }
        .cancel-display p{
            text-transform: uppercase;
            color: red;
            font-weight: bold;
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
                                <li class="breadcrumb-item">
                                    <a href="<?php echo e(url('account/orders')); ?>">Orders</a>
                                    <svg class="breadcrumb-arrow" width="6px" height="9px">
                                        <use xlink:href="<?php echo e(asset('client')); ?>/images/sprite.svg#arrow-rounded-right-6x9"></use>
                                    </svg>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page"><?php echo e($order->order_reference_number); ?></li>
                            </ol>
                        </nav>
                    </div>
                    <div class="page-header__title">
                        <h1>Track Order</h1>
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
                            <div class="card mb-2">
                              <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <h5>Delivery Address</h5>
                                        <h6><?php echo e($order->delivery_address->full_name); ?></h6>
                                        <p>
                                            <?php echo e($order->delivery_address->address1); ?>, 
                                            <?php if($order->delivery_address->address2): ?>
                                                <?php echo e($order->delivery_address->address2); ?>, 
                                             <?php endif; ?>
                                             <?php if($order->delivery_address->landmark): ?>
                                                <?php echo e($order->delivery_address->landmark); ?>, 
                                             <?php endif; ?>
                                             <?php echo e($order->delivery_address->city); ?>, 
                                             <?php echo e($order->delivery_address->state_details->name); ?>,
                                             <?php echo e($order->delivery_address->pincode); ?>

                                        </p>
                                        <p>Phone Number <?php echo e($order->delivery_address->phone); ?></p>
                                        <?php if($order->delivery_instructions): ?>
                                            <small><b>Delivery Instructions: </b><?php echo e($order->delivery_instructions); ?></small>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-4">
                                        <h6><?php echo e($order->order_reference_number); ?></h6>
                                        <p>Order Placed on <?php echo e(date('d M, Y h:i A', strtotime($order->created_at))); ?></p>
                                    </div>
                                </div>
                              </div>
                            </div>
                            <div class="card">
                              <div class="card-body p-3">
                                <?php if(count($order->details)>0): ?>
                                    <?php $__currentLoopData = $order->details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=> $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="row">
                                            <?php if($item->status <= 2): ?>
                                            <div class="col-md-12 text-right" id="cancel-holder-<?php echo e($item->id); ?>">
                                                <?php if($item->is_cancelled !=1): ?>
                                                    <?php if($item->status != $status->cancel_request_status): ?>
                                                        <a href="<?php echo e(route('account.orders.cancel-order', [$item->id])); ?>" data-target="#common-modal" class="show-modal"><small>Cancel Order</small></a>
                                                    <?php else: ?>
                                                        <small class="text-danger">Requested for cancel</small>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            </div>
                                            <?php endif; ?>
                                            <div class="col-md-5">
                                                <div class="media  p-3">
                                                  <img src="<?php if($item->product_variants->image_id && $item->product_variants->media): ?> <?php echo e(asset('public/'.$item->product_variants->media->thumb_file_path)); ?> <?php else: ?> <?php echo e($no_image); ?> <?php endif; ?>" onerror="this.onerror=null;this.src='<?php echo e($no_image); ?>'" style="max-width:75px;" class="mr-3">
                                                  <div class="media-body">
                                                    <h6><a href="<?php echo e(url($item->product_variants->slug)); ?>" class="text-dark"><?php echo e(str_limit($item->product_variants->name, $limit = 50, $end = '...')); ?></a></h6>
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
                                                    <p class="m-0"><small>Quantity: <?php echo e($item->quantity); ?></small></p>

                                                  </div>
                                                </div>
                                            </div>
                                            <div class="col-md-7">
                                                <?php if($item->is_cancelled !=1): ?>
                                                    <?php if(count($order_status)>0): ?>
                                                    <?php
                                                        $completed_status = $item->tracking_history->pluck('order_status_labels_master_id')->toArray();
                                                        $completed_status_notes = $item->tracking_history->pluck('notes', 'order_status_labels_master_id')->toArray();
                                                    ?>
                                                    <ul class="progress-tracker mt-3">
                                                        <?php $__currentLoopData = $order_status; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $o_status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php
                                                                $status_class = '';
                                                                if($o_status->id == $item->status)
                                                                    $status_class = 'is-active';
                                                                elseif(in_array($o_status->id, $completed_status))
                                                                    $status_class = 'is-complete';
                                                            ?>
                                                          <li class="progress-step <?php echo e($status_class); ?>">
                                                            <div class="progress-marker" data-title="<?php echo e(isset($completed_status_notes[$o_status->id])?$completed_status_notes[$o_status->id]:''); ?>"></div>
                                                            <div class="progress-text">
                                                              <p class="progress-title"><?php echo e($o_status->name); ?></p>
                                                            </div>
                                                          </li>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </ul>
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    <div class="cancel-display">
                                                        <p>Cancelled</p>
                                                        <small><?php echo e($item->get_status_note()); ?></small>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <?php if(count($order->details) != $key+1): ?>
                                        <div class="card-divider"></div>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                              </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

<div class="modal fade" id="common-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content p-3">
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('bottom'); ?>

    ##parent-placeholder-c03e9099aad17cb58e4fff1d93d751105735c9c2##
    <script src="<?php echo e(asset('assets/js/progress-tracker.js')); ?>"></script>
    <script>
    $( ".progress-marker" ).mouseenter(function() {
        var obj = $(this);
        if(obj.data('title') != '')
        {
            var html ='<div class="display_notes p-2">'+obj.data('title')+'</div>';
            obj.parents('ul').after(html);
        }
    });
    $( ".progress-marker" ).mouseleave(function() {
        var obj = $(this);
        obj.parents('ul').next('.display_notes').remove();
    });

    $(document).on('change', '#cancelReasonInput', function(){
        if($(this).val() == 'Other')
        {
            $('#specify-reason-section').show();
        }
        else
        {
            $('#specify-reason-section').hide();
        }
    });

    function validateCancel()
    {
        $('#CancelFrm').validate({
          rules:
          {
            cancel_reason: "required",
            other_reason: {
                required: function(element){
                    return $("#cancelReasonInput").val() =="Other";
                }
            }
          },
          messages:
          {
            cancel_reason: "Please section a cancel reason",
            other_reason: "Specify cancel reason",
          },
          errorPlacement: function (error, element) {
            error.insertAfter($(element).parent('div').find('span'));
          }
      });
    }

    $(document).on('click', '#cancel-reason-save-btn', function(){
        var obj = $(this);
        validateAddress();
        var id = $(this).data('id');
        var frmValid = $('#CancelFrm').valid();
        if(frmValid)
        {
            obj.prop('disabled', true);
            obj.html('Saving..');
            var formurl = $('#CancelFrm').attr('action');
            $.ajax({
              url: formurl, 
              type: "POST", 
              data: new FormData($('#CancelFrm')[0]),
              cache: false, 
              processData: false,
              contentType: false, 
              success: function(data) {
                obj.prop('disabled', false);
                obj.html('Save');

                if (typeof data.errors != "undefined") {
                  var errors = JSON.parse(JSON.stringify(data.errors))
                        $.each(errors, function (key, val) {
                            $("#" + key + "_error").text(val[0]);
                        });
                }
                else
                {
                  $('#common-modal').modal('hide');
                  $('body').removeClass('modal-open');
                  $('.modal-backdrop').remove();
                  $('#cancel-holder-'+id).html('<small class="text-danger">Requested for Cancel</small>');
                  Toast.fire({
                    title: 'Success!',
                    text: data.success,
                    icon: 'success',
                  });
                }
              },
              error:function(reject){
                  obj.prop('disabled', false);
                  obj.html('Save');
                  if( reject.status === 422 ) {
                        var errors = $.parseJSON(reject.responseText);
                        $.each(errors, function (key, val) {
                            $("#" + key + "_error").text(val[0]);
                        });
                  }
              }
            });
        }
      })
     
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('hykon.layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/works/public_html/hykon-beta/resources/views/hykon/orders/details.blade.php ENDPATH**/ ?>