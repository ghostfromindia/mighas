@extends('email.base')
@section('content')
    <div style="width: 100%; margin:5px 0 15px; ">
            <h2 style="font-size: 24px; color: #333; text-align: center; font-weight: 600; ">Reset Password</h2>
            <div style="clear: both;"></div>
    </div>
        <div style="width: 100%; margin:15px 0; text-align: center; ">
            <img src="{{URL::asset('images/email.jpg')}}" width="100%" style="max-width: 350px;">
            <p style="font-size: 14px; color: #333; text-align: center; margin:15px 0 40px; ">
                Thank you for using our application! Regards,<br/>
                Pittappillil Team
            </p>
            <div style="width: 100%; margin:35px 0 15px; text-align: center; height: 55px; ">
                <a style="background:#659a4c; color:#fff; padding:15px; font-size:16px; margin:0 7px 0 0; text-decoration: none;" href="{{ url('password/reset', $token) }}">Reset Password</a>
            </div>
            <p style="font-size: 14px; color: #333; text-align: center; margin:15px 0 40px; word-break: break-all; ">
                If you’re having trouble clicking the "Reset Password" button, <br/>
                copy and paste the URL below into your web browser: <a style="color: #659a4c;" href="{{ url('password/reset', $token) }}" target="blank">{{ url('password/reset', $token) }}</a>
            </p>
        </div>
@endsection
