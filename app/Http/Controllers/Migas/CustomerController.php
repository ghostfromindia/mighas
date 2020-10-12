<?php

namespace App\Http\Controllers\Migas;

use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Address;
use DB, Validator, Auth, Redirect, Hash;

class CustomerController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $user_id = $user->id;
        $address = DB::table('address')->select('address.id', 'full_name', 'address1', 'address2', 'landmark', 'city', 'states.name AS state_name', 'pincode', DB::raw("CONCAT(mobile_code, ' ', mobile_number) AS phone"), 'type', 'is_default')->join('states', 'address.state', '=', 'states.id')->where('user_id', $user_id)->where('is_default', 1)->first();
        return view('hykon.customers.index', ['address'=>$address]);
    }

    public function get_address($location, $address=null)
    {
        $obj = new Address;
        if($address)
        {
            $obj = Address::find($address);
        }
        return view('hykon.customers.address', ['obj'=>$obj, 'location'=>$location]);
    }

    public function save_address(Request $request)
    {
        $user_id = Auth::user()->id;
        $data = $request->all();
        $edit = null;
        $val_rules = [
            'full_name' => 'required|max:225',
            'mobile_number' => 'required',
            'address1' => 'required|max:225',
            'city' => 'required|max:225',
            'state' => 'required|max:225',
            'pincode' => 'required',
        ];
        $validator = Validator::make($data, $val_rules);
        if ($validator->fails()) {
            return response()->json(['success'=>false, 'errors' => $validator->errors()]);
        }
        
        $address_count = Address::where('user_id', $user_id)->count();
        if($address_count == 0)
            $data['is_default'] = 1;

        if(isset($data['id']))
        {
            $id = decrypt($data['id']);
            $address = Address::find($id);
            $edit = $id;
        }
        else
        {
            $address = new Address;
            $data['user_id'] = $user_id;
        }

        $address->fill($data);
        $address->save();
        
        $address = DB::table('address')->select('address.id', 'full_name', 'address1', 'address2', 'landmark', 'city', 'states.name AS state_name', 'pincode', DB::raw("CONCAT(mobile_code, ' ', mobile_number) AS phone"), 'type', 'is_default')->join('states', 'address.state', '=', 'states.id')->where('address.id', $address->id)->first();

        $returnHTML = view('hykon.includes.address')->with('address', $address)->with('from', $data['location'])->render();

        return response()->json(['success' => true, 'html'=>$returnHTML, 'location'=>$data['location'], 'is_edit'=>$edit]);
    }

    public function addresses()
    {
        $user = Auth::user();
        $user_id = $user->id;
        $addresses = DB::table('address')->select('address.id', 'full_name', 'address1', 'address2', 'landmark', 'city', 'states.name AS state_name', 'pincode', DB::raw("CONCAT(mobile_code, ' ', mobile_number) AS phone"), 'type', 'is_default')->join('states', 'address.state', '=', 'states.id')->where('user_id', $user_id)->orderBy('address.is_default', 'DESC')->orderBy('address.created_at', 'DESC')->get();
        return view('hykon.customers.addresses', ['addresses'=>$addresses]);
    }

    public function remove_address($id)
    {
        $user = Auth::user();
        $user_id = $user->id;
        if(Address::where('id', $id)->where('user_id', $user_id)->where('is_default', 0)->delete())
        {
            return response()->json(['success' => true]);
        }
        else
            return response()->json(['success' => false]);
    }

    public function make_default_address($id)
    {
        $user = Auth::user();
        $user_id = $user->id;
        if($obj = Address::where('id', $id)->where('user_id', $user_id)->first())
        {
            Address::where('user_id', $user_id)->where('is_default', 1)->update(['is_default'=>0]);
            $obj->is_default = 1;
            $obj->save();
            return response()->json(['success' => true]);
        }
        else
            return response()->json(['success' => false]);
        
    }

    public function add_delivery_instructions($address_id)
    {
        $user = Auth::user();
        $user_id = $user->id;
        if($obj = Address::where('id', $address_id)->where('user_id', $user_id)->first())
        {
            return view('hykon.customers.delivery_instruction_form', ['obj'=>$obj]);
        }
    }

    public function save_delivery_instructions(Request $request)
    {
        $data = $request->all();
        $id = decrypt($data['id']);
        $address = Address::find($id);
        $address->delivery_instructions = $data['delivery_instructions'];
        $address->save();
        return response()->json(['success' => true]);
    }

    public function edit_profile()
    {
        return view('hykon.customers.edit_profile');
    }

    public function save_profile(Request $request)
    {
        $user = Auth::user();

        $validatedData = $request->validate([
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'nullable|email|unique:users,email,'.$user->id,
            'username'=> 'nullable|numeric|unique:users,username,'.$user->id
        ]);
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        if(isset($request->email) && session('email'))
        {
            $user->email = $request->email;
            $user->email_verified_at = null;
        }
        if(isset($request->username) && session('mobile'))
        {
            $user->username = $request->username;
            $user->phone_verified_at = null;
        }
        $user->save();
        return Redirect::back()->withSuccess('User Details successfully updated!');
    }

    public function changePassword(Request $request){

        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            // The passwords matches
            return response()->json(['error' => 'Your current password does not matches with the password you provided. Please try again.']);
        }

        if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
            //Current password and new password are same
            return response()->json(['error' => 'New Password cannot be same as your current password. Please choose a different password.']);
        }

        $validatedData = $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:6|confirmed',
        ]);

        //Change Password
        $user = Auth::user();
        $user->password = bcrypt($request->get('new-password'));
        $user->save();

        return response()->json(['success' => 'Password changed successfully !']);
    }

}