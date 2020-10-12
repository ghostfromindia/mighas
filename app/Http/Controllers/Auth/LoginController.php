<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Socialite;
Use App\User;
use App\SocialIdentity;
use Redirect;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers {
        logout as performLogout;
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    public function redirectTo(){

        $user = Auth::user();
        if($user->hasRole('Admin'))
        {
            return 'admin/dashboard';
        }
        else
        {
            return 'account/dashboard';
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    public function login(Request $request)
    {
        $this->validate($request, [
            'login'    => 'required',
            'password' => 'required',
        ]);

        $login_type = filter_var($request->input('login'), FILTER_VALIDATE_EMAIL ) 
            ? 'email' 
            : 'username';

        $request->merge([
            $login_type => $request->input('login')
        ]);
       // print_r($request->all());exit;

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            if($request->ajax())
                return response()->json( $this->sendLockoutResponse($request));
            else
                return $this->sendLockoutResponse($request);
        }

        if (Auth::attempt($request->only($login_type, 'password'))) {
            $user = Auth::user();
            if($user->isBanned())
            {
                $this->performLogout($request);
                if($request->ajax())
                  return response()->json( ['message'=>'This account is inactive. Plase contact administrator for more details.'] );
                else
                  return Redirect::back()->withError('This account is inactive. Plase contact administrator for more details.');
            }
            if($request->ajax())
            {
                Cart::assign_cart($user->id);

                $redirect_page = ($request->input('referrer_page'))?$request->input('referrer_page'):'/';
                if($redirect_page == 'cart')
                  $redirect_page = 'checkout/address';
                return response()->json(['redirect'=>url($redirect_page)]);
            }
            else
                return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);
        if($request->ajax())
            return response()->json($this->sendFailedLoginResponse($request));
        else
            return $this->sendFailedLoginResponse($request);
    }

    public function logout(Request $request)
    {
        $user = Auth::user();
        if($user->hasRole('Admin'))
        {
            $redirect = 'admin';
        }
        else{
            $redirect = '/';
        }
        
        $this->performLogout($request);

        return redirect($redirect);
    }

    public function redirectToProvider($provider)
    {
       return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
       try {
           $user = Socialite::driver($provider)->user();
       } catch (Exception $e) {
           return redirect('/');
       }

       $authUser = $this->findOrCreateUser($user, $provider);
       Auth::login($authUser, true);

       return redirect($this->redirectTo());
    }

    public function handleProviderAjaxCallback(Request $request)
    {
       $provider = $request->provider;
       $user = $request->data;
       $authUser = $this->findOrCreateUserAjax($user, $provider);
       Auth::login($authUser, true);
        Cart::assign_cart(Auth::user()->id);

       return response()->json(['success'=>true]);
    }

    public function findOrCreateUserAjax($providerUser, $provider)
    {
       $account = SocialIdentity::whereProviderName($provider)
                  ->whereProviderId($providerUser['id'])
                  ->first();

       if ($account) {
           return $account->user;
       } else {
          $user = null;
          if(isset($providerUser['email']))
            $user = User::whereEmail($providerUser['email'])->first();

           if (! $user) {
               $first_name = null;
               $last_name = null;
               if(isset($providerUser['name']))
               {
                    $parts = explode(" ", $providerUser['name']);
                    if(count($parts) > 1) {
                        $last_name = array_pop($parts);
                        $first_name = implode(" ", $parts);
                    }
                    else
                        $first_name = $providerUser['name'];
               }
               $user = User::create([
                   'email' => isset($providerUser['email'])?$providerUser['email']:null,
                   'first_name'  => $first_name,
                   'last_name'  => $last_name,
               ]);
               $user->assignRole(['2']);
           }

           $user->identities()->create([
               'provider_id'   => $providerUser['id'],
               'provider_name' => $provider,
           ]);

           return $user;
       }
    }


    public function findOrCreateUser($providerUser, $provider)
    {
       $account = SocialIdentity::whereProviderName($provider)
                  ->whereProviderId($providerUser->getId())
                  ->first();

       if ($account) {
           return $account->user;
       } else {
           $user = User::whereEmail($providerUser->getEmail())->first();

           if (! $user) {
               $user = User::create([
                   'email' => $providerUser->getEmail(),
                   'name'  => $providerUser->getName(),
               ]);
           }

           $user->identities()->create([
               'provider_id'   => $providerUser->getId(),
               'provider_name' => $provider,
           ]);

           return $user;
       }
    }
}
