<?php echo $__env->make('admin.partials.notifications', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo Form::open(['url' => route('login'), 'role' => 'form', 'class' => 'p-t-15', 'id' => 'form-login']); ?>

            <!-- START Form Control-->
            <div class="form-group form-group-default">
              <label>Login</label>
              <div class="controls">
                <?php echo Form::text('login', null, ['class' => 'form-control', 'id' => 'inputEmail', 'placeholder' => 'Email or Username', 'required'=>true]); ?>

                <?php if ($errors->has('email')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('email'); ?>
                  <span class="invalid-feedback" role="alert">
                      <strong><?php echo e($message); ?></strong>
                  </span>
                <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
              </div>
            </div>
            <!-- END Form Control-->
            <!-- START Form Control-->
            <div class="form-group form-group-default">
              <label>Password</label>
              <div class="controls">
                <?php echo Form::password('password', ['class' => 'form-control', 'id' => 'inputPassword', 'placeholder' => 'Password', 'required'=>true]); ?>

                <?php if ($errors->has('password')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('password'); ?>
                  <span class="invalid-feedback" role="alert">
                      <strong><?php echo e($message); ?></strong>
                  </span>
                <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
              </div>
            </div>
            <!-- START Form Control-->
            <div class="row">
              <div class="col-md-6 no-padding sm-p-l-10">
                <div class="checkbox ">
                  <input type="checkbox" name="remember"/>
                  <label for="checkbox1">Keep Me Signed in</label>
                </div>
              </div>
            </div>
            <!-- END Form Control-->
            <button class="btn btn-primary btn-cons m-t-10" type="submit">Sign in</button>
            <!--<a href="<?php echo e(url('/login/facebook')); ?>" class="btn btn-facebook"><i class="fa fa-facebook"></i> Facebook</a>
            <a href="<?php echo e(url('/login/google')); ?>" class="btn btn-google"><i class="fa fa-google"></i> Google</a>-->
<?php echo Form::close(); ?><?php /**PATH /home/works/public_html/hykon-beta/resources/views/auth/login_content.blade.php ENDPATH**/ ?>