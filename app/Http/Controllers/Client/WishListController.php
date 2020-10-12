<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\WishList;
use Auth;

class WishListController extends Controller
{
    public function add(Request $request){
        $data = [];
        $data['total'] = $this->wishlist_total();
        $wishlist = WishList::where('user_id',$this->user_id())->where('variant_id',$request->variant_id)->first();
        if($request->type == 'check'){
            if($wishlist){$data['status'] = false;}else{$data['status'] = true;}      return json_encode($data);
        }
        if($request->type == 'remove'){
            if($wishlist) {$wishlist->delete(); }
            $data['status'] = true;
            $data['total'] = $this->wishlist_total();
            return json_encode($data);
        }
        if(!$wishlist){
            $wishlist = new WishList;
            $wishlist->user_id = $this->user_id();
            $wishlist->variant_id = $request->variant_id;
            $wishlist->save();
            $data['message'] = 'Amazing.. Product added to your wish-list';
        }else{
            $data['message'] = 'Product already added in Wish-list';
            $data['status'] = true;
        }
        return json_encode($data);
    }

    public function remove($wishlist_id){
        WishList::find(decrypt($wishlist_id))->delete();
        $data['message'] = 'Product removed from your wish-list';
        $data['status'] = true;
    }

    public function home(){
         $wishlists = WishList::where('user_id',$this->user_id())->get();
        return view('client/pages/wishlist',compact('wishlists'));
    }

    public function user_id(){
        if(Auth::user()){
            $user = Auth::user()->id;
        }else{
            $user = session('guest');
        }
        return $user;
    }

    public function wishlist_total(){
        $wishlist = WishList::where('user_id',$this->user_id())->get();
        return count($wishlist);
    }
}
