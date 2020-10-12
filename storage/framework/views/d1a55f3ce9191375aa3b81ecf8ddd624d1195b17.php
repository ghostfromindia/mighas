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
                                <li class="breadcrumb-item active" aria-current="page">Edit Profile</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="page-header__title">
                        <h1>Edit Profile</h1>
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
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="float-left">Edit Profile</h5>
                                    <a href="javascript:void(0);" class="btn btn-info float-right" data-toggle="modal" data-target="#update-password">Change Password</a>
                                </div>
                                <div class="card-divider"></div>
                                <div class="card-body">
                                    <form method="POST" action="<?php echo e(route('account.save-profile')); ?>" class="p-t-15" id="UserProfileFrm" data-validate=true>
                                        <?php echo csrf_field(); ?>
                                        <div class="row no-gutters">
                                            <div class="form-group col-md-6 pr-2">
                                                <label for="profile-first-name">First Name</label>
                                                <input type="text" name="first_name" value="<?php echo e(auth()->user()->first_name); ?>" class="form-control" id="profile-first-name" placeholder="First Name">
                                            </div>
                                            <div class="form-group col-md-6 pr-2">
                                                <label for="profile-last-name">Last Name</label>
                                                <input type="text" name="last_name" value="<?php echo e(auth()->user()->last_name); ?>" class="form-control" id="profile-last-name" placeholder="Last Name">
                                            </div>
                                            <div class="form-group col-md-6 pr-2"> <?php if(!auth()->user()->email){session()->put('email',true);}  ?>
                                                <label for="profile-email">Email Address</label><?php if(!session('email')): ?><a href="javascript:void(0);" class="float-right input-enable" data-target="#profile-email" data-type="email" data-encrypt-type="<?php echo e(encrypt('email')); ?>">Change</a><?php endif; ?>
                                                <input type="email" name="email" value="<?php echo e(auth()->user()->email); ?>" class="form-control" id="profile-email" placeholder="Email Address" <?php if(!session('email')): ?> disabled="disabled" <?php endif; ?>>
                                            </div>
                                            
                                                
                                                
                                            
                                            <div class="form-group col-md-12">
                                                <button class="btn btn-primary">Update</button>
                                            </div>

                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('bottom'); ?>
    <?php if($message = Session::get('success')): ?>
            <script>
                Toast.fire({
                    title: 'Success!',
                    text: '<?php echo e($message); ?>',
                    icon: 'success',
                  });
            </script>
    <?php endif; ?>
    <script>

        $(document).on('click', '.input-enable', function() {
            var type = $(this).data('type');
            var e_type = $(this).data('encrypt-type');
            $.post('<?php echo e(url('/send/otp')); ?>',{_token:csrf,type:type}).done(function (data) {
                var obj = JSON.parse(data);
                console.log(obj.status)
                if (obj.status == 101) {
                    $.alert('You now have the permission to change your mobile number');
                    location.reload()
                    return false;
                }

                $.confirm({
                    title: 'Please enter the otp!',
                    content: '' +
                        '<form action="" class="formName">' +
                        '<div class="form-group">' +
                        '<label>Please enter the otp we send to your '+type+'</label>' +
                        '<input type="email" placeholder="eg, 523 890" class="otp form-control" required />' +
                        '</div>' +
                        '</form>',
                    buttons: {
                        formSubmit: {
                            text: 'Submit',
                            btnClass: 'btn-blue',
                            action: function () {
                                var otp = this.$content.find('.otp').val();


                                if (!otp) {
                                    $.alert('Please enter the otp');
                                    return false;
                                }

                                $.post('<?php echo e(url('otp/verify')); ?>', {_token: csrf, otp: otp, type:e_type}).done(function (data) {
                                    var obj = JSON.parse(data);
                                    console.log(obj.status)
                                    if (!obj.status) {
                                        $.alert('The given OTP is Invalid.');
                                        return false;
                                    }
                                    if (obj.type == 'email') {
                                        $.alert('OTP is verified. You now have the permission to change your email address');
                                        location.reload()
                                    }

                                    if (obj.type == 'mobile') {
                                        $.alert('OTP is verified. You now have the permission to change your mobile number');
                                        location.reload()
                                    }
                                })


                            }
                        },
                        cancel: function () {
                            //close
                        },
                    },
                    onContentReady: function () {
                        // bind to events
                        var jc = this;
                        this.$content.find('form').on('submit', function (e) {
                            // if the user submits the form by pressing enter in the field.
                            e.preventDefault();
                            jc.$$formSubmit.trigger('click'); // reference the button and click it
                        });
                    }
                });
            })




        });



        $(document).on('click', '.input-enable-', function(){
                var target = $(this).data('target');
                if($(target).is(':disabled')){
                    $(target).prop('disabled', false);
                    $(this).text('Cancel');
                    if(target == '#profile-email')
                    {
                        $('#profile-email').rules('add', {
                            required: true,
                            email: true,
                            remote: {
                                url: "<?php echo e(route('validate.unique.user-email')); ?>",
                            },
                            messages: {
                                required: "Email cannot be blank",
                                remote: "Email is already in use",
                            }
                        });
                    }
                    else{
                        $('#profile-phone').rules('add', {
                            required: true,
                            digits:true,
                            remote: {
                                url: "<?php echo e(route('validate.unique.user-phone')); ?>",
                            },
                            messages: {
                                required: "Phone number cannot be blank",
                                remote: "Phone number is already in use",
                            }
                        });
                    }
                }
                else{
                    $(target).prop('disabled', true);
                    $(this).text('Change');
                    if(target == '#profile-email')
                    {
                        $('#profile-email').rules('remove', 'required email remote');
                    }
                    else{
                        $('#profile-phone').rules('remove', 'required digits remote');
                    }
                }
            });

    var validator = $('#UserProfileFrm').validate({
            rules: {
                "first_name": "required",
              },
              messages: {
                "first_name": "First name cannot be blank",
              },
            });

    if($('#profile-email').is(':enabled')){
        $('#profile-email').rules('add', {
                required: true,
                email: true,
                remote: {
                    url: "<?php echo e(route('validate.unique.user-email')); ?>",
                },
                messages: {
                    required: "Email cannot be blank",
                    remote: "Email is already in use",
                }
        });
    }

    if($('#profile-phone').is(':enabled')){
        $('#profile-phone').rules('add', {
                            required: true,
                            digits:true,
                            remote: {
                                url: "<?php echo e(route('validate.unique.user-phone')); ?>",
                            },
                            messages: {
                                required: "Phone number cannot be blank",
                                remote: "Phone number is already in use",
                            }
                        });
    }

        $('#updatePasswordFrm').validate({
  rules:{
    "current-password":{
      required:true
    },
    "new-password":{
      required:true
    },
    "new-password_confirmation":{
      required:true,
      equalTo: "#new-password"
   }
  },
  messages:{
    "current-password":{
      required:"Please enter your current password"
    },
    "new-password":{
      required:"Please enter a new password"
    },
    "new-password_confirmation":{
      required:"Please confirm new password"
    }
  },
  submitHandler:function(form){
    $('#change-password-btn').html('Changing...');
    var formurl = $('#updatePasswordFrm').attr('action');
    $.ajax({
        url: formurl , 
        type: "POST", 
        data: new FormData(form),
        cache: false, 
        processData: false,
        contentType: false, 
        success: function(data) {
          if(typeof data.success != "undefined")
          {
              $('#update-password').modal('hide');
              $('body').removeClass('modal-open');
              $('.modal-backdrop').remove();
              Toast.fire({
                title: 'Success!',
                text: data.success,
                icon: 'success',
              });
          }
          else
          {
              $('#change-password-btn').html('Change Password');
              Toast.fire({
                title: 'Error!',
                text: data.error,
                icon: 'error',
              });
          }
        },
        error:function(xhr){
            $('#change-password-btn').html('Change Password');
            var errors = JSON.parse(JSON.stringify(xhr.responseText))
            $.each(errors, function (key, val) {
                $("#" + key + "_error").text(val[0]);
            });
        }
     });
  }
});
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('hykon.layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/works/public_html/hykon-beta/resources/views/hykon/customers/edit_profile.blade.php ENDPATH**/ ?>