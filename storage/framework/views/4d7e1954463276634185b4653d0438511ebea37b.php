<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <meta charset="utf-8" />
    <title>Hykon</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, shrink-to-fit=no" />
    <link rel="apple-touch-icon" href="pages/ico/60.png">
    <link rel="apple-touch-icon" sizes="76x76" href="pages/ico/76.png">
    <link rel="apple-touch-icon" sizes="120x120" href="pages/ico/120.png">
    <link rel="apple-touch-icon" sizes="152x152" href="pages/ico/152.png">
    <link rel="icon" type="image/x-icon" href="favicon.ico" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta content="" name="description" />
    <meta content="" name="author" />
    <meta content="<?php echo e(csrf_token()); ?>" name="csrf-token" />
    <?php echo $__env->make('admin.common.styles', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <link href="<?php echo e(URL::to('')); ?>/pages/css/pages-icons.css" rel="stylesheet" type="text/css">
    <!--<link class="main-stylesheet" href="<?php echo e(URL::to('')); ?>/pages/css/pages.css" rel="stylesheet" type="text/css" />-->
    <?php $__env->startSection('head'); ?>
    <?php echo $__env->yieldSection(); ?>
    <link  href="<?php echo e(URL::asset('public/pages/css/themes/modern.css')); ?>" rel="stylesheet" type="text/css" />
    <link  href="<?php echo e(URL::asset('public/assets/css/style.css')); ?>" rel="stylesheet" type="text/css" />
    <style>
        @media (min-width: 1200px){
            .container {
                max-width: 95%;
            }
        }

        .page-heading{
            text-align: left;
        }

        .page-sidebar .sidebar-menu .menu-items > li > a > .title{
            width:  85%;
        }

        .page-sidebar .sidebar-menu .menu-items > li > a > .arrow {
            padding-right: 10px;
        }
        .page-sidebar .sidebar-header {
            display: block;
            font-size: 18px;
        }
    </style>
</head>
<body class="fixed-header menu-pin">
<!-- BEGIN SIDEBPANEL-->
<?php echo $__env->make('admin.common.nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<!-- END SIDEBAR -->
<!-- END SIDEBPANEL-->
<!-- START PAGE-CONTAINER -->
<div class="page-container ">
    <!-- START HEADER -->
    <div class="header ">
        <!-- START MOBILE SIDEBAR TOGGLE -->
        <a href="#" class="btn-link toggle-sidebar d-lg-none pg pg-menu" data-toggle="sidebar">
        </a>
        <!-- END MOBILE SIDEBAR TOGGLE -->
        <div class="">
            <div class="brand inline">
                <?php echo e(Key::get('site_name')); ?>

            </div>

        </div>
        <div class="d-flex align-items-center">
            <!-- START User Info-->
            <div class="pull-left p-r-10 fs-14 font-heading d-lg-block d-none">
                <?php if(auth()->guard()->check()): ?>
                    <span class="semi-bold font-weight-bold"><?php echo e(Auth::user()->username); ?></span>
                    <span class="text-master font-italic">(<?php echo e(Auth::user()->email); ?>)</span>
                <?php endif; ?>
            </div>
            <div class="dropdown pull-right d-lg-block d-none">
                <button class="profile-dropdown-toggle" type="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false" style="cursor: pointer">
              <span class="thumbnail-wrapper d32  inline">
              <img src="https://img.icons8.com/office/32/000000/user-menu-male--v2.png" alt=""
                   data-src="https://img.icons8.com/office/32/000000/user-menu-male--v2.png"
                   data-src-retina="https://img.icons8.com/office/32/000000/user-menu-male--v2.png" width="32" height="32">
              </span>
                </button>
                <div class="dropdown-menu dropdown-menu-right profile-dropdown" role="menu">
                    <a href="#" class="dropdown-item"><i class="pg-settings_small"></i> Change Password</a>
                    <a href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="clearfix bg-master-lighter dropdown-item">
                        <span class="pull-left">Logout</span>
                        <span class="pull-right"><i class="pg-power"></i></span>
                    </a>
                    <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                       <?php echo csrf_field(); ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- END HEADER -->
    <!-- START PAGE CONTENT WRAPPER -->
    <div class="page-content-wrapper ">
        <!-- START PAGE CONTENT -->
        <div class="content ">
            <!-- START JUMBOTRON -->
            <div class="jumbotron page-wrapper" data-pages="parallax">
                <?php $__env->startSection('breadcrumb'); ?>
                    <?php echo $__env->yieldSection(); ?>
            </div>
            <!-- END JUMBOTRON -->
            <!-- START CONTAINER FLUID -->
            <div class=" container-fluid   container-fixed-lg">
                <?php echo $__env->make('admin.partials.notifications', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php $__env->startSection('content'); ?>
                    <?php echo $__env->yieldSection(); ?>
            </div>
            <!-- END CONTAINER FLUID -->
        </div>
        <!-- END PAGE CONTENT -->
        <!-- START COPYRIGHT -->
        <!-- START CONTAINER FLUID -->
        <!-- START CONTAINER FLUID -->
        <div class=" container-fluid  container-fixed-lg footer">
            <div class="copyright sm-text-center">
                <p class="small no-margin pull-left sm-pull-reset">
                    <span class="hint-text">Copyright &copy; <?php echo e(date('Y')); ?> </span>
                    <span class="font-montserrat">Spiderworks</span>.
                    <span class="hint-text">All rights reserved. </span>
                </p>
                <p class="small no-margin pull-right sm-pull-reset">
                    Hand-crafted <span class="hint-text">&amp; made with Love</span>
                </p>
                <div class="clearfix"></div>
            </div>
        </div>
        <!-- END COPYRIGHT -->
    </div>
    <!-- END PAGE CONTENT WRAPPER -->
</div>
<!-- END PAGE CONTAINER -->
<!--START QUICKVIEW -->

<!-- END QUICKVIEW-->
<!-- START OVERLAY -->

<!-- END OVERLAY -->
<!-- BEGIN VENDOR JS -->
<?php echo $__env->make('admin.common.scripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->yieldPushContent('scripts'); ?>
<script type="text/javascript">
    var image_upload_url = "<?php echo e(url('admin/summernote/image')); ?>";
    var _token = "<?php echo e(csrf_token()); ?>";
    var base_url = "<?php echo e(url('/')); ?>";
</script>
<?php $__env->startSection('bottom'); ?>
<?php echo $__env->yieldSection(); ?>
<!-- END PAGE LEVEL JS -->
<script src="<?php echo e(asset('public/js/spiderworks.js')); ?>"></script>
<script>
    $(document).ready(function () {
        $('table').attr('width','100%');
        $('#datatable_wrapper').parent().removeClass('padding-15').addClass('padding-5');
    });

</script>

</body>
</html><?php /**PATH /home/works/public_html/hykon-beta/resources/views/admin/common/base.blade.php ENDPATH**/ ?>