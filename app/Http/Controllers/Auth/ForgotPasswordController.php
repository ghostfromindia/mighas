<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use DB, Carbon;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Notification;
use App\Notifications\PasswordReset;
use App\User;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
    
    public function sendResetLinkEmail(Request $request)
    {
        $this->validateInput($request);

        $login_type = filter_var($request->input('email'), FILTER_VALIDATE_EMAIL ) ? 'email' : 'mobile';
        if($login_type == 'mobile')
        {
            $mobile = preg_replace("/[^0-9]/", "", $request->email);
            if(strlen($mobile) != 10)
                return $this->sendResetLinkFailedResponse($request, 'Invalid Input!');
        }
        $user_query = DB::table('users')->whereNull('deleted_at');
        if($login_type == 'email')
            $user_query->where('email', '=', $request->email);
        else
            $user_query->where('username', '=', $request->email);
        $user = $user_query->first();
        //Check if the user exists
        if (!$user)
            return $this->sendResetLinkFailedResponse($request, 'User not found!');

        //Create Password Reset Token
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => str_random(60),
            'created_at' => date('Y-m-d H:i:s')
        ]);
        //Get the token just created above
        $tokenData = DB::table('password_resets')
            ->where('email', $request->email)->first();

        if($login_type == 'email')
        {
            $notif_user = User::find($user->id);
            Notification::send($notif_user, new PasswordReset($tokenData->token));
        }
        else
        {
            $message = 'Click to reset password '. url('password/reset', $tokenData->token); 
            BaseController::sms_send($mobile, $message);
        }
        return $this->sendResetLinkResponse($request, 'A reset link has been sent to your '.$login_type.'.');
    }

    protected function validateInput(Request $request)
    {
        $request->validate(['email' => 'required']);
    }

    /**
     * Get the response for a successful password reset link.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetLinkResponse(Request $request, $response)
    {
        if($request->ajax())
            return response()->json( ['success'=>trans($response)] );
        else
            return back()->with('status', trans($response));
    }

    /**
     * Get the response for a failed password reset link.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        if($request->ajax())
            return response()->json( ['error'=>trans($response)] );
        else
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => trans($response)]);
    }

}
