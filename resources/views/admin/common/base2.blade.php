<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <meta name="csrf-token" content="{{csrf_token()}}">
    <meta charset="utf-8" />
    <title>@yield('page_title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, shrink-to-fit=no" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    @include('admin.common.styles')
    {{--Page dependencies CSS--}}
    @section('head')
    @show
    {{--Page dependencies end CSS--}}

    <link class="main-stylesheet" href="{{asset('public/pages/css/themes/modern.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('public/pages/css/pages-icons.css')}}" rel="stylesheet" type="text/css">
    <link href="{{URL::asset('/')}}/assets/css/style.css" rel="stylesheet" type="text/css" media="screen" />
</head>
<body class="fixed-header horizontal-menu horizontal-app-menu dashboard">
<div class="header p-r-0 bg-primary">
    <div class="header-inner header-md-height">

        <a href="#" class="btn-link toggle-sidebar d-lg-none pg pg-menu text-white" data-toggle="horizontal-menu"></a>

        <div class="">
            <div class="brand inline no-border d-sm-inline-block" style="color:white">
                PITTAPPILLIL
            </div>
        </div>

        <div class="d-flex align-items-center">

            <div class="pull-left p-r-10 fs-14 font-heading d-lg-inline-block d-none text-white">
                <span class="semi-bold">{{ Auth::user()->first_name.' '.Auth::user()->last_name}}</span>
            </div>

            <div class="dropdown pull-right">
                <button class="profile-dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="thumbnail-wrapper d32 circular inline sm-m-r-5">
                            <i class="pg-menu_justify" style="color: white;"></i>
                        </span>
                </button>
                <div class="dropdown-menu dropdown-menu-right profile-dropdown" role="menu">
                    <a href="#" class="dropdown-item"><i class="pg-settings_small"></i> Settings</a>
                    <a class="clearfix bg-master-lighter dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
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
    @include('admin.common.nav')
</div>

<div class="page-container ">
    <div class="page-content-wrapper ">

        <div class="content sm-gutter">
            <div class="bg-white">
                @include('admin.common.breadcrumbs')
            </div>
            @include('admin.partials.notifications')
            <div class="container sm-padding-10 p-t-20 p-l-0 p-r-0 page-wrapper">
                <div class="row">
                    @section('content')
                    @show
                </div>
            </div>
        </div>

        @include('admin.common.footer')
    </div>
</div>

@include('admin.common.scripts')

<script>
    $('#notification-center').append('<span class="bubble"></span>')
</script>
<script src="{{asset('public/pages/js/pages.min.js')}}"></script>
<script src="{{asset('public/assets/js/dashboard.js')}}" type="text/javascript"></script>
<script src="{{asset('public/assets/js/scripts.js')}}" type="text/javascript"></script>
<script type="text/javascript" src="{{URL::to('')}}/assets/plugins/select2/js/select2.full.min.js"></script>
<script type="text/javascript" src="{{URL::to('')}}/assets/plugins/classie/classie.js"></script>
<script src="{{URL::to('')}}/assets/plugins/switchery/js/switchery.min.js" type="text/javascript"></script>
<script>
    var image_upload_url = '{{route('admin.summernote.image')}}';
</script>



@section('bottom')
@show
@stack('scripts')
<script src="{{asset('public/js/spiderworks.js')}}"></script>
{{--Page dependencies end JS--}}
</body>
</html>