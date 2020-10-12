<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="format-detection" content="telephone=no">
    <title><?php echo $__env->yieldContent('title','Hykon India Limited'); ?></title>
    <meta name="description" content="<?php echo $__env->yieldContent('meta_description'); ?>">
    <meta name="keywords" content="<?php echo $__env->yieldContent('meta_keywords'); ?>">
    <link rel="icon" type="image/png" href="<?php echo e(asset('hykon-ui')); ?>/images/favicon.png">
    <!-- fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- css -->
    <link rel="stylesheet" href="<?php echo e(asset('hykon-ui')); ?>/vendor/bootstrap-4.2.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo e(asset('hykon-ui')); ?>/vendor/owl-carousel-2.3.4/assets/owl.carousel.min.css">

    <link rel="stylesheet" href="<?php echo e(asset('hykon-ui')); ?>/vendor/select2-4.0.10/css/select2.min.css">
    <link rel="stylesheet" href="<?php echo e(asset('hykon-ui')); ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo e(asset('hykon-ui')); ?>/css/style-new.css">
    <!-- font - fontawesome -->
    <link rel="stylesheet" href="<?php echo e(asset('hykon-ui')); ?>/vendor/fontawesome-5.6.1/css/all.min.css">
    <!-- font - stroyka -->
    <link rel="stylesheet" href="<?php echo e(asset('hykon-ui')); ?>/fonts/stroyka/stroyka.css">


    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    
    <style>
        .megamenu__links a {
            text-transform: capitalize;
        }
        .menu__item-link {
            text-transform: uppercase;
        }
        html {
            scroll-behavior: smooth;
        }
        .error{
            color:red;
        }
        .mobile-links--level--0>.mobile-links__item>.mobile-links__item-title .mobile-links__item-link {
            text-transform: uppercase;
            padding: 12px 20px;
        }
        [dir=ltr] .product-card__badges-list {
            left: 18px;
            max-width: 200px;
        }
        
     
        
        .fixed-logo {
  position: fixed;
  right: -340px;
  top: 200px;
  width: 340px;
  z-index: 100;
  transition: 1s;
}
     .banner-form.active {
     overflow: scroll;
  width: 280px;
  height: 500px;
  overflow: hidden;
  visibility: visible;
  opacity: 1;
  -ms-transform: scale(1);
  /* IE 9 */
  
  -webkit-transform: scale(1);
  /* Safari 3-8 */
  
  transform: scale(1);
}    

.main-contact-icon-right-sd {
    position: fixed;
    right: 20px;
    top: 135px;
    z-index: 99;
}

        .branch-results {
            border-radius: 5px;
            padding: 20px;
            color: #fff;
            background: #3970ad;
            position: relative;
            margin: 10px 0;
            min-height: 175px;
        }

    </style>
    
    <script>
        const baseUrl = '<?php echo e(url('/')); ?>';
        const csrf = '<?php echo e(csrf_token()); ?>';
        const image_upload_url = '<?php echo e(url('/')); ?>';
    </script>
    <?php $__env->startSection('head'); ?>
        <?php echo $__env->yieldSection(); ?>
        
        <!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/5f4f2356f0e7167d000cb4a8/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->

</head>
<body>


        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content login-popup">
                <div class="modal-body p-0">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <div class="row m-0 login-cntr">
                        <div class="col-md-5 load-pop-bg d-flex flex-column justify-content-center ">
                            <a href="<?php echo e(url('/')); ?>">
                                <img src="<?php echo e(Key::get('white-logo')); ?>" class="" width="150">
                            </a>
                            <h3> Post your queries. We will assist you to choose the right product</h3>
                        </div>
                        <div class="col-md-7 p-0 load-pop-form">
                            <div class="">
                                <div class="card-body">
                                    <span style="color: red" id="common-popup-error"></span>
                                    <form id="common-popup" method="post" action="<?php echo e(url('lead')); ?>">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="form" value="common-popup">
                                        <input type="hidden" name="type" value="lead">
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input type="text" class="form-control" name="name" placeholder="Enter Name">
                                        </div>
                                        <div class="form-group">
                                            <label>Email address  </label>
                                            <input type="email" class="form-control" name="email" placeholder="Enter email  ">
                                        </div>
                                        <div class="form-group">
                                            <label>  Phone Number</label>
                                            <input type="text" class="form-control" name="phone" placeholder="Enter Phone">
                                        </div>
                                        <div class="form-group">
                                          <label for="exampleFormControlSelect1">Sales/Service/AMC</label>
                                        <select class="form-control" id="exampleFormControlSelect1">
                                            <option selected>Enter Your Requirement  </option>
                                            <option>Sale</option>
                                            <option>Service</option>
                                              <option>AMC</option>
                                        </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Message</label>
                                            <input   type="TEXT" class="form-control" name="message" placeholder="message">
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary float-left" id="common-popup-submit">Submit</button>
                                            <div class="clearfix"></div>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>

<div class="main-contact-icon-right-sd">
     <a class="slide-left" href="tel:+919946043000">
    <div class="call-right quick-contact">
        <a class="slide-left" href="tel:+919946043000"><span>99 4604 3000</span></a>
    </div></a>
    <div class="mail-right quick-contact">
        <a href="https://wa.me/919946043000" class="slide-left"><span class="span">
            99 4604 3000</span></a>
    </div>
</div>
<!-- quickview-modal -->
<div id="quickview-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content"></div>
    </div>
</div>
<!-- quickview-modal / end -->
<!-- login-modal -->
<div id="login-register"  class="modal fade"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content login-popup">

            <div class="modal-body p-0">




                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

                <div class="row m-0 login-cntr">
                    <div class="col-md-5 login-bg d-flex flex-column justify-content-center ">
                        <a href="<?php echo e(url('/')); ?>">
                            <img src="<?php echo e(Key::get('site_logo')); ?>" class="" width="220">
                        </a>
                        <h3> Shop for your favourite home appliance at best prices</h3>
                    </div>
                    <div class="col-md-7 p-0">

                        <div class="">
                            <div class="card-body">
                                <h3 class="card-title">Login</h3>
                                <div class="login-errors mt-2 mb-2 text-danger"></div>
                                <form method="POST" action="<?php echo e(route('login')); ?>" id="loginForm">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="referrer_page" value="<?php echo e(Request::path()); ?>">
                                    <div class="form-group">
                                        <label>Email address / Phone Number</label>
                                        <input id="login" type="text" class="form-control <?php if ($errors->has('login')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('login'); ?> is-invalid <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>" name="login" value="<?php echo e(old('login')); ?>" required autocomplete="email" placeholder="Enter email or Phone">
                                    </div>
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input id="password-field" type="password" class="form-control" placeholder="Password" name="password">
                                        <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                        <small class="form-text text-muted">
                                            <a href="<?php echo e(route('password.request')); ?>" class="open-forgot">Forgotten Password</a>
                                        </small>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-check">
                                                <span class="form-check-input input-check">
                                                    <span class="input-check__body">
                                                        <input class="input-check__input" type="checkbox" name="remember" id="remember" <?php echo e(old('remember') ? 'checked' : ''); ?>>
                                                        <span class="input-check__box"></span>
                                                        <svg class="input-check__icon" width="9px" height="7px">
                                                            <use xlink:href="<?php echo e(URL::asset('client')); ?>/images/sprite.svg#check-9x7"></use>
                                                        </svg>
                                                    </span>
                                                </span>
                                            <label class="form-check-label" for="login-remember">Remember Me</label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary float-left" id="login-btn">Login</button>
                                        <a class=" mt-1 ml-2 float-left new-user-btn" id="reg-btn">Create New account?</a>
                                        <div class="clearfix"></div>
                                    </div>



                                </form>
                            </div>
                        </div>




                    </div>
                </div>




                <div class="row m-0  reg-cntr" style="display: none;">
                    <div class="col-md-5 login-bg d-flex flex-column justify-content-center ">
                        <a href="<?php echo e(url('/')); ?>">
                            <img src="<?php echo e(Key::get('site_logo')); ?>" class="" width="220">
                        </a>
                        <h3> Shop for your favourite home appliance at best prices</h3>
                    </div>
                    <div class="col-md-7 p-0">





                        <div >
                            <div class="card-body">
                                <h3 class="card-title">Register</h3>
                                <div class="register-errors mt-2 mb-2 text-danger"></div>
                                <form method="POST" action="<?php echo e(route('register')); ?>" id="registerForm">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="referrer_page" value="<?php echo e(Request::path()); ?>">
                                    <div class="form-group">
                                        <label>Email address / Phone Number</label>
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend" style="display: none;" id="phone-holder">
                                                <div class="input-group-text">+91</div>
                                            </div>
                                            <input id="phone_email" type="input" class="form-control <?php if ($errors->has('phone_email')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('phone_email'); ?> is-invalid <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>" name="phone_email" value="<?php echo e(old('phone_email')); ?>" required autocomplete="phone_email" placeholder="Enter email or phone">
                                            <?php if ($errors->has('phone_email')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('phone_email'); ?>
                                            <span class="invalid-feedback" role="alert">
                                                          <strong><?php echo e($message); ?></strong>
                                                      </span>
                                            <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                                            <input type="hidden" name="email" readonly="" id="hidden_email">
                                            <input type="hidden" name="username" readonly="" id="hidden_phone">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <div class="col-md-6 mb-3">
                                            <label>First Name</label>
                                            <input id="first_name" type="text" class="form-control <?php if ($errors->has('first_name')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('first_name'); ?> is-invalid <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>" name="first_name" value="<?php echo e(old('first_name')); ?>" required autocomplete="first_name" placeholder="First Name ">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label>Last Name</label>
                                            <input id="last_name" type="text" class="form-control <?php if ($errors->has('last_name')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('last_name'); ?> is-invalid <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>" name="last_name" value="<?php echo e(old('last_name')); ?>" autocomplete="last_name" placeholder="Last Name ">
                                        </div>

                                    </div>


                                    <div class="form-group">
                                        <input id="password-field2" type="password" class="form-control" placeholder="Password" name="password">
                                        <span toggle="#password-field2" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary float-left" id="register-btn">Register</button>
                                        <a class=" mt-1 ml-2 float-left new-user-btn" id="log-btn">Login</a>
                                        <div class="clearfix"></div>
                                    </div>



                                </form>
                            </div>
                        </div>
                    </div>
                </div>


            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="forgot-password" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Forgot Password</h5>
                <a  class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </a>
            </div>
            <form action="<?php echo e(route('password.email')); ?>" id="forgotPasswordForm" method="post" class="form-horizontal style-form" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="modal-body login-main">
                    <div class="alert alert-danger" role="alert" id="forgot-password-error" style="display:none;">
                        This is a danger alert—check it out!
                    </div>
                    <div class="form-group">
                        <input type="text"  class="form-control" name="email" id="email_forgot" value="" placeholder="Enter your registered email address or mobile number">
                    </div>

                    <div class="form-group form-check">
                        <button type="submit" class="reg-btn btn btn-danger reset-btn"><?php echo e(__('Send Password Reset Link')); ?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- login-modal / end -->

<!-- mobilemenu -->
<?php echo $__env->make('hykon.menu.mobile', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<!-- mobilemenu / end -->
<!-- site -->
<div class="site">
<!-- mobile site__header -->
    <header class="site__header  d-lg-none">
        <!-- data-sticky-mode - one of [pullToShow, alwaysOnTop] -->
        <div class="mobile-header mobile-header--sticky" data-sticky-mode="pullToShow">  
            <div class="mobile-header__panel <?php if(Request::url() !== url('/')): ?> inner-nav <?php endif; ?>">
                <div class="container">
                    <div class="mobile-header__body">
                        <button class="mobile-header__menu-button">
                            <svg width="18px" height="14px">
                                <use xlink:href="<?php echo e(asset('hykon-ui')); ?>/images/sprite.svg#menu-18x14"></use>
                            </svg>
                        </button>
                        
                        <div class="mobile-header__search">
                            <form class="mobile-header__search-form" action="<?php echo e(url('search')); ?>" method="get">
                                <input class="mobile-header__search-input" name="search" placeholder="Search over 10,000 products" aria-label="Site search" type="text" autocomplete="off">
                                <button class="mobile-header__search-button mobile-header__search-button--submit" type="submit">
                                    <svg width="20px" height="20px">
                                        <use xlink:href="<?php echo e(asset('hykon-ui')); ?>/images/sprite.svg#search-20"></use>
                                    </svg>
                                </button>
                                <button class="mobile-header__search-button mobile-header__search-button--close" type="button">
                                    <svg width="20px" height="20px">
                                        <use xlink:href="<?php echo e(asset('hykon-ui')); ?>/images/sprite.svg#cross-20"></use>
                                    </svg>
                                </button>
                                <div class="mobile-header__search-body"></div>
                            </form>
                        </div>
                        <div class="mobile-header__indicators ">
                            <div class="indicator indicator--mobile-search indicator--mobile d-sm-none">
                                <button class="indicator__button">
                                 <span class="indicator__area">
                                    <svg width="20px" height="20px">
                                       <use xlink:href="<?php echo e(asset('hykon-ui')); ?>/images/sprite.svg#search-20"></use>
                                    </svg>
                                 </span>
                                </button>
                            </div>
                          
                            <div class="indicator indicator--mobile">
                                <a href="<?php echo e(url('cart')); ?>" class="indicator__button">
                                 <span class="indicator__area">
                                    <svg width="20px" height="20px">
                                       <use xlink:href="<?php echo e(asset('hykon-ui')); ?>/images/sprite.svg#cart-20"></use>
                                    </svg>
                                    <span class="indicator__value"><?php if(auth()->guard()->check()): ?> <?php echo e(\App\Models\Cart::count(Auth::user()->id)); ?> <?php else: ?> <?php echo e(\App\Models\Cart::count(session('guest'))); ?> <?php endif; ?></span>
                                 </span>
                                </a>
                            </div>

                              <div class="indicator indicator--mobile d-sm-flex  ">
                               <!--- <a href="<?php echo e(url('wishlist')); ?>" class="indicator__button">
                                 <span class="indicator__area">
                                    <svg width="20px" height="20px">
                                       <use xlink:href="<?php echo e(asset('hykon-ui')); ?>/images/sprite.svg#heart-20"></use>
                                    </svg>
                                    <span class="indicator__value">0</span>
                                 </span>
                                </a> --->
                                <a data-toggle="modal" href="#login-register" id="open-register" class="indicator__button">
                               <span class="indicator__area">
                                  <i class="fas fa-user text-light"></i>
                                 
                               </span>
                            </a>
                            </div>

                        </div>
                        <a class="mobile-header__logo" href="<?php echo e(url('/')); ?>">
                            <img src="<?php echo e(Key::get('site_logo')); ?>" class="" width="150">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- mobile site__header / end -->
    <!-- desktop site__header -->
    <header class="site__header d-lg-block d-none index-heder">
        <div class="site-header">
            <div class="top-pattern">
                <img src="<?php echo e(asset('hykon-ui')); ?>/images/patt-top.png"/>
            </div>


            <div class="site-header__middle container">

                <div class="site-header__search">
                    <div class="search">
                        <form class="search__form" action="<?php echo e(url('search')); ?>" method="get">
                            <input class="search__input" name="search" placeholder="What can we help you find?" aria-label="Site search" type="text" autocomplete="off">
                            <button class="search__button" type="submit">
                                <svg width="20px" height="20px">
                                    <use xlink:href="<?php echo e(asset('hykon-ui')); ?>/images/sprite.svg#search-20"></use>
                                </svg>
                            </button>
                            <div class="search__border"></div>
                            <div class="autocomplete-cntr" style="display: none;">
                                <div class="auto-list">
                                    <a href="#">
                                        <img src="<?php echo e(asset('hykon-ui')); ?>/images/prd-1.png" width="50" />
                                        <h4>Inverter</h4>
                                        <p>in Inverters</p>
                                    </a>
                                </div>
                                <hr/>
                                <div class="auto-list">
                                    <a href="#">
                                        <svg width="20px" height="20px">
                                            <use xlink:href="<?php echo e(asset('hykon-ui')); ?>/images/sprite.svg#search-20"></use>
                                        </svg>
                                        <h4>Inverter</h4>
                                        <p>in Inverters</p>
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="nav-panel__indicators">
                    <div class="indicator">
                        <?php if(auth()->guard()->check()): ?>
                            <a href="<?php echo e(url('account/dashboard')); ?>" class="indicator__button">
                               <span class="indicator__area2">
                                  <i class="fas fa-user"></i>
                                  <div><?php echo e(Auth::user()->first_name); ?></div>
                               </span>
                            </a>
                            <?php else: ?>
                            <a data-toggle="modal" href="#login-register" id="open-register" class="indicator__button">
                               <span class="indicator__area2">
                                  <i class="fas fa-user"></i>
                                  <div>Login</div>
                               </span>
                            </a>
                        <?php endif; ?>

                    </div>
                    <div class="indicator">
                        <a href="<?php echo e(url('company/career')); ?>" class="indicator__button">
                           <span class="indicator__area2">
                              <i class="fas fa-suitcase"></i>
                              <div>Career</div>
                           </span>
                        </a>
                    </div>
                    <div class="indicator">
                        <a href="<?php echo e(url('company/contact')); ?>" class="indicator__button">
                           <span class="indicator__area2">
                              <i class="fas fa-phone"></i>
                              <div>Contact Us</div>
                           </span>
                        </a>
                    </div>
                    <div class="indicator ">
                        <a href="<?php echo e(url('cart')); ?>" class="indicator__button">
                           <span class="indicator__area">
                              <svg width="20px" height="20px">
                                 <use xlink:href="<?php echo e(asset('hykon-ui')); ?>/images/sprite.svg#cart-20"></use>
                              </svg>
                              <span class="indicator__value"><?php if(auth()->guard()->check()): ?> <?php echo e(\App\Models\Cart::count(Auth::user()->id)); ?> <?php else: ?> <?php echo e(\App\Models\Cart::count(session('guest'))); ?> <?php endif; ?></span>
                           </span>
                        </a>

                    </div>
                </div>

                <div class="site-header__logo">
                    <a href="<?php echo e(url('/')); ?>">
                        <img src="<?php echo e(Key::get('site_logo')); ?>" class="" width="180">
                    </a>
                </div>
            </div>
            <div class="site-header__nav-panel">
                <!-- data-sticky-mode - one of [pullToShow, alwaysOnTop] -->
                <?php echo $__env->make('hykon.menu.desktop', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </div>
    </header>
    <!-- desktop site__header / end -->
    <?php if(empty(session('need-help-dev'))): ?>
    <div class="fixed-logo">
        <a class="fixed-logo-close"> Need help? </a>
        <div class="banner-form active">
            <a><i class="fas fa-times-circle"></i></a>
            <span class="error" id="need-help-erros"></span>
            <h3>Post your queries. We will assist you to choose the right product</h3>
            <form id="need-help" action="<?php echo e(url('lead')); ?>"  method="post"> <?php echo csrf_field(); ?>
                <input type="hidden" name="form" value="need-help">
                <input type="hidden" name="type" value="lead">
                <div class="form-group">
                    <input type="text" class="form-control" name="name" placeholder="Name">
                </div>
                <div class="form-group">
                    <input type="mail" class="form-control" name="email" placeholder="Email">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="phone" placeholder="Phone">
                </div>
                <div class="form-group">
                       <label for="exampleFormControlSelect1">Sales/Service/AMC</label>
                                        <select class="form-control" id="exampleFormControlSelect1">
                                            <option selected>Enter Your Requirement  </option>
                                            <option>Sale</option>
                                            <option>Service</option>
                                              <option>AMC</option>
                                        </select>
                </div>
                <div class="form-group">
                    <textarea  class="form-control" name="message" placeholder="Enter your message"></textarea>
                </div>
                <div class="form-group m-0">
                    <button type="submit" class="btn " id="need-help-button">SUBMIT</button>
                    <div class="clearfix"></div>
                </div>
            </form>
        </div>
    </div>
    <?php endif; ?>

    <!-- site__body -->
    <?php $__env->startSection('content'); ?>
        <?php echo $__env->yieldSection(); ?>
    <!-- site__body / end -->


    <!-- site__footer -->
    <footer class="site__footer">
        
        <?php if(Request::url() !== url('/')): ?>
            <div class="patt-banner">
                <img src="<?php echo e(asset('hykon-ui/images/footer-patern.png')); ?>" height="150">
            </div>
        <?php endif; ?>    
            
        <div class="site-footer">
            <div class="container">
                <div class="site-footer__widgets">
                    <div class="row">
                        <div class="col-6  col-md-3 col-lg-3">
                            <div class="site-footer__widget footer-links">
                                <h5 class="footer-links__title">Popular Products</h5>
                                <ul class="footer-links__list">
                                    <?php echo app('arrilot.widget')->run('BottomMenu', ['name'=>'footer-1']); ?>
                                </ul>
                            </div>
                        </div>
                        <div class="col-6 col-md-3 col-lg-3">
                            <div class="site-footer__widget footer-links">
                                <h5 class="footer-links__title">Popular Categories</h5>
                                <ul class="footer-links__list">
                                    <?php echo app('arrilot.widget')->run('BottomMenu', ['name'=>'footer-2']); ?>
                                </ul>
                            </div>
                        </div>
                        <div class="col-6 col-md-3 col-lg-2 mob-dis-none">
                            <div class="site-footer__widget footer-links">
                                <h5 class="footer-links__title">Quick Links</h5>
                                <ul class="footer-links__list">
                                    <?php echo app('arrilot.widget')->run('BottomMenu', ['name'=>'footer-3']); ?>
                                </ul>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-4">
                            <div class="site-footer__widget footer-newsletter">

                                <?php if(session()->has('subscribed')): ?> <?php else: ?>
                                    <div id="new_568_letter" class="news-fld">
                                        <h5 class="footer-newsletter__title"><?php echo e($common_settings['newsletter-head']); ?></h5>
                                        <div class="footer-newsletter__text">
                                            <?php echo e($common_settings['newsletter-content']); ?>

                                        </div>
                                        <form action="<?php echo e(url('newsletter/save')); ?>" method="POST" class="footer-newsletter__form" id="newsletterFrm">
                                            <?php echo csrf_field(); ?>
                                            <label class="sr-only" for="footer-newsletter-address">Email Address</label>
                                            <input type="text" name="email" class="footer-newsletter__form-input form-control" id="footer-newsletter-address" placeholder="Email Address...">
                                            <button class="footer-newsletter__form-button btn btn-primary" id="subscribe-btn">Subscribe</button>
                                        </form>
                                        <span class="text-danger " id="email_error"></span>
                                    </div>
                                <?php endif; ?>

                                <?php if(isset($common_settings['footer-contact'])): ?>
                                    <div class="footer-newsletter__text footer-newsletter__text--social">
                                        <?php echo e($common_settings['social-media']->title); ?>

                                    </div>
                                    <ul class="footer-newsletter__social-links">
                                        <?php $__currentLoopData = $common_settings['social-media']->social_media; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if($key == 'facebook' && $link != ''): ?>
                                                <li class="footer-newsletter__social-link footer-newsletter__social-link--facebook"><a href="<?php echo e($link); ?>" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                                            <?php endif; ?>
                                            <?php if($key == 'twitter' && $link != ''): ?>
                                                <li class="footer-newsletter__social-link footer-newsletter__social-link--twitter"><a href="<?php echo e($link); ?>" target="_blank"><i class="fab fa-twitter"></i></a></li>
                                            <?php endif; ?>
                                            <?php if($key == 'youtube' && $link != ''): ?>
                                                <li class="footer-newsletter__social-link footer-newsletter__social-link--youtube"><a href="<?php echo e($link); ?>" target="_blank"><i class="fab fa-youtube"></i></a></li>
                                            <?php endif; ?>
                                            <?php if($key == 'instagram' && $link != ''): ?>
                                                <li class="footer-newsletter__social-link footer-newsletter__social-link--instagram" ><a href="<?php echo e($link); ?>" target="_blank"><i class="fab fa-instagram"></i></a></li>
                                            <?php endif; ?>
                                            <?php if($key == 'linkedin' && $link != ''): ?>
                                                <li class="footer-newsletter__social-link footer-newsletter__social-link--linkedin"><a href="<?php echo e($link); ?>" target="_blank" ><i class="fab fa-linkedin-in"></i></a></li>
                                            <?php endif; ?>
                                            <?php if($key == 'pinterest' && $link != ''): ?>
                                                <li class="footer-newsletter__social-link footer-newsletter__social-link--pinterest"><a href="<?php echo e($link); ?>" target="_blank"><i class="fab fa-pinterest-p"></i></a></li>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="site-footer__mid">
                    <div class="container">
                        <div class="row">
                            <div class="  col-md-12 text-right ">
                                <img src="<?php echo e(asset('hykon-ui')); ?>/images/hykon-logo.png" width="120"/>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="site-footer__bottom">
                <div class="site-footer__copyright">
                    © <?php echo e(date('Y')); ?> Hykon India Limited. All rights reserved. Designed and Developed by <a href="https://www.spiderworks.in/" style="color: #fdfdfd" target="_blank">SpiderWorks</a>
                </div>
            </div>
            <div class="totop">
                <div class="totop__body">
                    <div class="totop__start"></div>
                    <div class="totop__container container"></div>
                    <div class="totop__end">
                        <button type="button" class="totop__button">
                            <svg width="13px" height="8px">
                                <use xlink:href="<?php echo e(asset('hykon-ui')); ?>/images/sprite.svg#arrow-rounded-up-13x8"></use>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- site__footer / end -->
</div>
<!-- site / end -->

<!-- js -->
<script src="<?php echo e(asset('hykon-ui')); ?>/vendor/jquery-3.3.1/jquery.min.js"></script>

<script src="<?php echo e(asset('hykon-ui')); ?>/vendor/bootstrap-4.2.1/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo e(asset('hykon-ui')); ?>/vendor/owl-carousel-2.3.4/owl.carousel.min.js"></script>
<script src="<?php echo e(asset('hykon-ui')); ?>/vendor/nouislider-12.1.0/nouislider.min.js"></script>
<script src="<?php echo e(asset('hykon-ui')); ?>/vendor/select2-4.0.10/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.9/slick.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.js"></script>
<script src="<?php echo e(asset('hykon-ui')); ?>/js/number.js"></script>
<script src="<?php echo e(asset('hykon-ui')); ?>/js/main.js"></script>
<script src="<?php echo e(asset('hykon-ui')); ?>/js/header.js"></script>
<script src="<?php echo e(asset('assets/plugins/swal/sweetalert2.all.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/plugins/jquery-validation/js/jquery.validate.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/spiderworks.min.js')); ?>"></script>
<script src="<?php echo e(asset('hykon-ui')); ?>/js/hykon.js"></script>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    svg4everybody();
</script>
<script>
    $(document).ready(function(){

        /* login */
        $("#reg-btn").click(function(){
            $(".login-cntr").css("display","none");
            $(".reg-cntr").css("display","flex");
        });


        $("#log-btn").click(function(){
            $(".login-cntr").css("display","flex");
            $(".reg-cntr").css("display","none");
        });


        $(".toggle-password").click(function() {

            $(this).toggleClass("fa-eye fa-eye-slash");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });


        // Get titles from the DOM
        var titleMain = $("#slick-wrapper");

        if (titleMain.length) {

            titleMain.slick({

                dots: false,
                slidesToShow: 5,
                centerMode: true,
                centerPadding: "10px",
                draggable: true,
                infinite: true,
                pauseOnHover: true,
                swipe: false,
                touchMove: false,
                vertical: true,
                speed: 1000,
                autoplaySpeed: 2000,
                useTransform: true,
                cssEase: 'cubic-bezier(0.645, 0.045, 0.355, 1.000)',
                adaptiveHeight: true,
                autoplay: true,
                arrows: false,
                prevArrow: '<i class="fa fa-chevron-circle-up" style="font-size:30px;color:#f79007"></i>',
                nextArrow: '<i class="fa fa-chevron-circle-down" style="font-size:30px;color:#f79007"></i>'
            });

            // On init
            $(".slick-item").each(function(index, el) {
                $("#animatedHeading").slick('slickAdd', "<div>" + el.innerHTML + "</div>");
            });

            // Manually refresh positioning of slick
            titleMain.slick('slickPlay');

        };


        (function ($) {
            $.fn.countTo = function (options) {
                options = options || {};

                return $(this).each(function () {
                    // set options for current element
                    var settings = $.extend({}, $.fn.countTo.defaults, {
                        from:            $(this).data('from'),
                        to:              $(this).data('to'),
                        speed:           $(this).data('speed'),
                        refreshInterval: $(this).data('refresh-interval'),
                        decimals:        $(this).data('decimals')
                    }, options);

                    // how many times to update the value, and how much to increment the value on each update
                    var loops = Math.ceil(settings.speed / settings.refreshInterval),
                        increment = (settings.to - settings.from) / loops;

                    // references & variables that will change with each update
                    var self = this,
                        $self = $(this),
                        loopCount = 0,
                        value = settings.from,
                        data = $self.data('countTo') || {};

                    $self.data('countTo', data);

                    // if an existing interval can be found, clear it first
                    if (data.interval) {
                        clearInterval(data.interval);
                    }
                    data.interval = setInterval(updateTimer, settings.refreshInterval);

                    // initialize the element with the starting value
                    render(value);

                    function updateTimer() {
                        value += increment;
                        loopCount++;

                        render(value);

                        if (typeof(settings.onUpdate) == 'function') {
                            settings.onUpdate.call(self, value);
                        }

                        if (loopCount >= loops) {
                            // remove the interval
                            $self.removeData('countTo');
                            clearInterval(data.interval);
                            value = settings.to;

                            if (typeof(settings.onComplete) == 'function') {
                                settings.onComplete.call(self, value);
                            }
                        }
                    }

                    function render(value) {
                        var formattedValue = settings.formatter.call(self, value, settings);
                        $self.html(formattedValue);
                    }
                });
            };

            $.fn.countTo.defaults = {
                from: 0,               // the number the element should start at
                to: 0,                 // the number the element should end at
                speed: 500,           // how long it should take to count between the target numbers
                refreshInterval: 100,  // how often the element should be updated
                decimals: 0,           // the number of decimal places to show
                formatter: formatter,  // handler for formatting the value before rendering
                onUpdate: null,        // callback method for every time the element is updated
                onComplete: null       // callback method for when the element finishes updating
            };

            function formatter(value, settings) {
                return value.toFixed(settings.decimals);
            }
        }(jQuery));

        jQuery(function ($) {
            // custom formatting example
            $('.count-number').data('countToOptions', {
                formatter: function (value, options) {
                    return value.toFixed(options.decimals).replace(/\B(?=(?:\d{3})+(?!\d))/g, ',');
                }
            });

            // start all the timers
            $('.timer').each(count);

            function count(options) {
                var $this = $(this);
                options = $.extend({}, options || {}, $this.data('countToOptions') || {});
                $this.countTo(options);
            }
        });







    });
</script>
<script>
    $(document).ready(function(){

        AOS.init({
            easing: 'ease-out-back',
            duration: 1000
        });



        //
        // $('input.search__input').focus(function() {
        //     $('.autocomplete-cntr').show();
        //     $(document).bind('focusin.autocomplete-cntr click.autocomplete-cntr',function(e) {
        //         if ($(e.target).closest('.autocomplete-cntr, input.search__input').length) return;
        //         $(document).unbind('.autocomplete-cntr');
        //         $('.autocomplete-cntr').fadeOut('medium');
        //     });
        // });
        // $('.autocomplete-cntr').hide();



        $('.js-example-basic-single').select2();

        $(".fixed-logo-close").click(function () {
            $(".fixed-logo").toggleClass("active");
        });


        $(".banner-form a").click(function () {
            $(".fixed-logo").toggleClass("active");
        });

    });
</script>
<script type="text/javascript">
    var mod = sessionStorage.getItem("ex_modal");
    if(!mod){
        $(window).on('load',function(){
            var delayMs = 10000; // delay in milliseconds

            setTimeout(function(){
                $('#exampleModal').modal('show');
                sessionStorage.setItem("ex_modal", true);
            }, delayMs);
        });
    }


</script>
<script type="text/javascript">

    $(document).ready(function(){
    $('.call-action').click(function () {
        $("#exampleModal").modal()
    })
    });
    </script>
    
<?php $__env->startSection('bottom'); ?>
<?php echo $__env->yieldSection(); ?>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\hykon\resources\views/hykon/layouts/base.blade.php ENDPATH**/ ?>