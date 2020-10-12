<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Cart;
use App\Models\Cart AS ProductCart;
use App\Http\Controllers\BaseController;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $vaild = Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'phone_email' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'email', 'max:255', 'unique:users'],
            'username' => ['nullable', 'numeric', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ], [
        'username.unique' => 'The phone number has already been taken.',
        ]);

        if($vaild->fails()){
            return json_encode(['errors'=>$vaild->errors()]);
        }

        return true;
    }

    public function register(Request $request)
    {
        $v = $this->validator($request->all());

        if(!is_bool($v)){
            return $v;
        }

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);
        ProductCart::assign_cart($user->id);
        
        BaseController::send_notification('Your sign up proccess completed successfully','Successfully register with Pittappillil online');
        
        if($request->ajax())
        {
                $redirect_page = ($request->input('referrer_page'))?$request->input('referrer_page'):'/';
                if($redirect_page == 'cart')
                  $redirect_page = 'checkout/address';
                return json_encode(['redirect'=>url($redirect_page)]);
        }
        else
            return $this->registered($request, $user)?: redirect($this->redirectPath());
        
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
        ]);
        $user->assignRole(['2']);
        return $user;
    }

    protected function registered(Request $request, $user)
    {
        return "true";
    }
}
