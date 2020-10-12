@include('admin.partials.notifications')
{!! Form::open(['url' => route('login'), 'role' => 'form', 'class' => 'p-t-15', 'id' => 'form-login']) !!}
            <!-- START Form Control-->
            <div class="form-group form-group-default">
              <label>Login</label>
              <div class="controls">
                {!! Form::text('login', null, ['class' => 'form-control', 'id' => 'inputEmail', 'placeholder' => 'Email or Username', 'required'=>true]) !!}
                @error('email')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div>
            <!-- END Form Control-->
            <!-- START Form Control-->
            <div class="form-group form-group-default">
              <label>Password</label>
              <div class="controls">
                {!! Form::password('password', ['class' => 'form-control', 'id' => 'inputPassword', 'placeholder' => 'Password', 'required'=>true]) !!}
                @error('password')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
                @enderror
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
            <!--<a href="{{ url('/login/facebook') }}" class="btn btn-facebook"><i class="fa fa-facebook"></i> Facebook</a>
            <a href="{{url('/login/google')}}" class="btn btn-google"><i class="fa fa-google"></i> Google</a>-->
{!! Form::close() !!}