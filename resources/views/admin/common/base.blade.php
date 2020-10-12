<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <meta charset="utf-8" />
    <title>Mighas Backend</title>
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
    <meta content="{{csrf_token()}}" name="csrf-token" />
    @include('admin.common.styles')
    <link href="{{URL::to('')}}/pages/css/pages-icons.css" rel="stylesheet" type="text/css">
    <!--<link class="main-stylesheet" href="{{URL::to('')}}/pages/css/pages.css" rel="stylesheet" type="text/css" />-->
    @section('head')
    @show
    <link  href="{{URL::asset('public/pages/css/themes/modern.css')}}" rel="stylesheet" type="text/css" />
    <link  href="{{URL::asset('public/assets/css/style.css')}}" rel="stylesheet" type="text/css" />
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
@include('admin.common.nav')
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
                {{Key::get('site_name')}}
            </div>

        </div>
        <div class="d-flex align-items-center">
            <!-- START User Info-->
            <div class="pull-left p-r-10 fs-14 font-heading d-lg-block d-none">
                @auth
                    <span class="semi-bold font-weight-bold">{{Auth::user()->username}}</span>
                    <span class="text-master font-italic">({{Auth::user()->email}})</span>
                @endauth
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
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="clearfix bg-master-lighter dropdown-item">
                        <span class="pull-left">Logout</span>
                        <span class="pull-right"><i class="pg-power"></i></span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                       @csrf
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
                @section('breadcrumb')
                    @show
            </div>
            <!-- END JUMBOTRON -->
            <!-- START CONTAINER FLUID -->
            <div class=" container-fluid   container-fixed-lg">
                @include('admin.partials.notifications')
                @section('content')
                    @show
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
                    <span class="hint-text">Copyright &copy; {{date('Y')}} </span>
                    <span class="font-montserrat">Ghost Science</span>.
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
@include('admin.common.scripts')
@stack('scripts')
<script type="text/javascript">
    var image_upload_url = "{{ url('admin/summernote/image') }}";
    var _token = "{{csrf_token()}}";
    var base_url = "{{url('/')}}";
</script>
@section('bottom')
@show
<!-- END PAGE LEVEL JS -->
<script src="{{asset('assets/js/mighas.js')}}"></script>
<script>
    $(document).ready(function () {
        $('table').attr('width','100%');
        $('#datatable_wrapper').parent().removeClass('padding-15').addClass('padding-5');
    });

</script>

</body>
</html>