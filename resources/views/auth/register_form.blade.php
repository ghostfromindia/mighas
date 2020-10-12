<form method="POST" action="{{ route('register') }}" id="registerForm">
                        @csrf
                        <div class="form-group row">
                            <div class="col-md-12">
                              <label for="phone_email" class="col-form-label">Email Address / Phone Number</label>
                              <div class="input-group mb-2">
                                <div class="input-group-prepend" style="display: none;" id="phone-holder">
                                  <div class="input-group-text">+91</div>
                                </div>
                                <input id="phone_email" type="input" class="form-control @error('phone_email') is-invalid @enderror" name="phone_email" value="{{ old('phone_email') }}" required autocomplete="phone_email">
                                    @error('phone_email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                <input type="hidden" name="email" readonly="" id="hidden_email">
                                <input type="hidden" name="username" readonly="" id="hidden_phone">
                              </div>
                          </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="first_name" class="col-form-label">First Name</label>
                                <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required autocomplete="first_name">

                                @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="last_name" class="col-form-label">Last Name</label>
                                <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" autocomplete="last_name">

                                @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="password" class="col-form-label">{{ __('Password') }}</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="password-confirm" class="col-form-label">{{ __('Confirm Password') }}</label>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                        <div class="text-center mt-2">                        <!-- Display login status -->
                            <a href="javascript:void(0);" class="btn btn-facebook" onclick="fbLogin()" id="fbLink"><i class="fas fa-facebook"></i> Facebook</a>
                            <a href="javascript:void(0);" class="btn btn-google" id="googleSignIn"><i class="fas fa-google"></i> Google</a>
                        </div>
                    </form>