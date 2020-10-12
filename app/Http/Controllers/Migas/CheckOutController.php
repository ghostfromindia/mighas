<?php

namespace App\Http\Controllers\Migas;

use App\Models\Address;
use App\Models\Cart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Validator;

class CheckOutController extends Controller
{
    public function address(){
        $user = Input::get('create');
        if(!$user){abort(404);}
        $address = Address::where('user_id',decrypt($user))->get();
        $cart = Cart::where('user_id',decrypt($user))->get();
        return view('hykon.pages.checkout.address',compact('address','cart'));
    }

    public function overview(){
        return view('hykon.pages.checkout.overview');
    }

    public function save_address(Request $request){

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
            session()->flash('error_log','Invalid data, Please check your entry');
            return redirect('checkout/address?create='.encrypt($user_id));
        }

        $address_count = Address::where('user_id', $user_id)->count();
        if($address_count == 0){
            $data['is_default'] = 1;
        }else{
            $add = Address::where('user_id', $user_id)->get();
            foreach ($add as $obj){
                $a = Address::find($obj->id); $a->is_default = 0; $a->save();
            }
        }
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
        return redirect('checkout/address?create='.encrypt($user_id));

    }

    public function summary(Request $request){
        $address =  Address::find(decrypt($request->address));
        $cart =  Cart::where('user_id',Auth::user()->id)->get();
        if(count($cart)==0){
            abort(404);
        }
        if(!$address){return redirect('checkout/address?create='.encrypt(Auth::user()->id));}
        return view('hykon.pages.checkout.overview',compact('cart','address'));
    }

}
