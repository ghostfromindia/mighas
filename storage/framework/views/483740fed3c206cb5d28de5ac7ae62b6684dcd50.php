<?php $__env->startSection('content'); ?>

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
                                <li class="breadcrumb-item active" aria-current="page">Manage Addresses</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="page-header__title">
                        <h1>Manage Addresses</h1>
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
                            <div class="addresses-list">
                                <a href="<?php echo e(url('account/address/address')); ?>" class="addresses-list__item addresses-list__item--new show-modal" id="add-new-address-btn" data-target="#common-modal">
                                    <div class="addresses-list__plus"></div>
                                    <div class="btn btn-secondary btn-sm">Add New</div>
                                </a>
                                <?php if(count($addresses)>0): ?>
                                    <?php $__currentLoopData = $addresses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$address): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="addresses-list__divider" id="address-list-divider-<?php echo e($address->id); ?>"></div>
                                        <div class="addresses-list__item card address-card" id="address-list-item-<?php echo e($address->id); ?>">
                                            <?php echo $__env->make('client.includes.address', ['address'=>$address, 'from'=>'address'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        </div>
                                        <?php if($key+1 == count($addresses)): ?>
                                            <div class="addresses-list__divider"></div>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
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

<script>
    $(document).on('click', '.address-list-remove', function(){
        var obj = $(this);
        var id = obj.data('id');
        Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, remove it!'
        }).then((result) => {
          if (result.value) {
            obj.replaceWith('<i class="fas fa-spinner fa-spin"></i>');
            $.get("<?php echo e(url('account/address-remove')); ?>"+"/"+id, function(data){
                if(data.success == true)
                {
                    $('#address-list-divider-'+id).remove();
                    $('#address-list-item-'+id).remove();
                    Toast.fire({
                        title: 'Success!',
                        text: 'Address successfully removed!',
                        icon: 'success',
                      });
                }
                else{
                    Toast.fire({
                        title: 'Error!',
                        text: 'Oops, something went wrong.Please try again!',
                        icon: 'error',
                      });
                }
            });
          }
        });
    });

    $(document).on('click', '.address-list-default', function(){
            var obj = $(this);
            var id = obj.data('id');
            obj.html('&nbsp;&nbsp;<i class="fas fa-spinner fa-spin"></i>');
            $.get("<?php echo e(url('account/address-make-default')); ?>"+"/"+id, function(data){
                if(data.success == true)
                {
                    $('.address-list-remove').show();
                    $('.address-list-default').show();
                    $('#address-list-remove-'+id).hide();
                    $('#address-list-default-'+id).hide();
                    obj.html('&nbsp;|&nbsp;Make Default');
                    $('.address-card__badge').remove();
                    $( '<div class="address-card__badge">Default</div>' ).insertBefore( "#card-body-"+id );
                    Toast.fire({
                        title: 'Success!',
                        text: 'Address successfully made default!',
                        icon: 'success',
                      });
                }
                else{
                    Toast.fire({
                        title: 'Error!',
                        text: 'Oops, something went wrong.Please try again!',
                        icon: 'error',
                      });
                }
            });
        });

    $(document).on('click', '#address-save-btn', function(){
        var obj = $(this);
        validateAddress();
        var frmValid = $('#AddressFrm').valid();
        if(frmValid)
        {
            obj.prop('disabled', true);
            obj.html('Saving..');
            var formurl = $('#AddressFrm').attr('action');
            $.ajax({
                url: formurl,
                type: "POST",
                data: new FormData($('#AddressFrm')[0]),
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
                        if(data.location == 'home')
                        {
                            $('#address-home-new-add').hide();
                            $('#address-home-display').show().html(data.html);
                        }
                        else{
                            if(data.is_edit != null)
                            {
                                $('#address-list-item-'+data.is_edit).html(data.html);
                            }
                            else{
                                var html = '<div class="addresses-list__divider"></div>';
                                html += '<div class="addresses-list__item card address-card">';
                                html += data.html;
                                html += '</div>';
                                $(html).insertAfter($('#add-new-address-btn'));
                            }
                        }
                        Toast.fire({
                            title: 'Success!',
                            text: 'Address saved successfully!',
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
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('hykon.layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/works/public_html/hykon-beta/resources/views/hykon/customers/addresses.blade.php ENDPATH**/ ?>