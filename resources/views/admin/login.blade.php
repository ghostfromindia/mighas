<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <meta charset="utf-8" />
    <title>Migas</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, shrink-to-fit=no" />
    <link rel="apple-touch-icon" href="{{ asset('public/assets/pages/ico/60.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('public/assets/pages/ico/76.png')}}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{asset('public/public/assets/pages/ico/120.png')}}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{asset('public/assets/pages/ico/152.png')}}">
    <link rel="icon" type="image/x-icon" href="favicon.ico" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta content="" name="description" />
    <meta content="" name="author" />
    <link href="{{asset('public/assets/plugins/pace/pace-theme-flash.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('public/assets/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('public/assets/plugins/font-awesome/css/font-awesome.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('public/assets/admin/css/pages-icons.css')}}" rel="stylesheet" type="text/css">
    <link class="main-stylesheet" href="{{asset('public/assets/admin/css/modern.css')}}" rel="stylesheet" type="text/css" />
    <style>
      .login-wrapper {
          background-color: #dddddd4f !important;
      }
     .clock-cntr{
       width: calc(100% - 500px);
        
      }
       #myclock {
        margin: 0 auto;
        max-width: 250px;

      }
    </style>
    <script type="text/javascript">
    window.onload = function()
    {
      // fix for windows 8
      if (navigator.appVersion.indexOf("Windows NT 6.2") != -1)
        var fix_link = "{{asset('public/assets/admin/css/windows.chrome.fix.css')}}";
        document.head.innerHTML += '<link rel="stylesheet" type="text/css" href="'+fix_link+'" />'
    }
    </script>
  </head>
  <body class="fixed-header ">
    <div class="login-wrapper ">
      <!-- START Login Background Pic Wrapper-->
      <div class="bg-pic">
        <!-- START Background Pic-->
          
        <!-- END Background Pic-->
        <!-- START Background Caption-->
        <div class="bg-caption pull-bottom sm-pull-bottom text-white p-l-20 m-b-20">
          {{Key::get('site_name')}}
        </div>
        <!-- END Background Caption-->
      </div>

            
               

      <!-- END Login Background Pic Wrapper-->
      <!-- START Login Right Container-->
      <div class="login-container bg-white">
        <div class="p-l-50 m-l-20 p-r-50 m-r-20 p-t-50 m-t-30 sm-p-l-15 sm-p-r-15 sm-p-t-40">
          <img src="{{Key::get('site_logo')}}" alt="logo"
               data-src="{{Key::get('site_logo')}}"
               data-src-retina="{{Key::get('site_logo')}}" width="300" >
          <p class="p-t-35">Sign into your {{Key::get('site_name')}} account</p>
          <!-- START Login Form -->
            @include('auth.login_content')
          <!--END Login Form-->
        </div>
      </div>

    <div class="clock-cntr d-flex align-items-center">
       <div id="myclock" ></div> 
     </div>    
      <!-- END Login Right Container-->
    </div>
 
    <!-- BEGIN VENDOR JS -->
    <script src="{{asset('public/assets/plugins/pace/pace.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('public/assets/plugins/jquery/jquery-3.2.1.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('public/assets/plugins/bootstrap/js/bootstrap.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('public/assets/plugins/jquery-actual/jquery.actual.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('public/assets/plugins/classie/classie.js')}}"></script>
    <script src="{{asset('public/assets/plugins/jquery-validation/js/jquery.validate.min.js')}}" type="text/javascript"></script>
    <!-- END VENDOR JS -->
    <script src="{{asset('public/assets/admin/js/pages.min.js')}}"></script>
    <script src="{{asset('assets/plugins/jQuery-Canvas-thooClock/js/jquery.thooClock.js')}}"></script>
    <script>
    $(function()
    {
      $('#form-login').validate();

      $('#myclock').thooClock({
      });

    })
    </script>
  </body>
</html>