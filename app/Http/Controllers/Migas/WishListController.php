<?php

namespace App\Http\Controllers\Migas;

use App\Models\WishList;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class WishListController extends Controller
{
    public function show_wishlist(){
        if(!Auth::user()){
            abort(404);
        }
        $user_id = Auth::user()->id;
        $wishlist = WishList::where('user_id',$user_id)->get();
        return view('hykon.pages.wishlist',compact('wishlist'));
    }

    public function add_wishlist(Request $request){
        $data = [];
        if(!Auth::user()){
            abort(404);
        }
        $user_id = Auth::user()->id;
        $variant_id = decrypt($request->variant);
        $wishlist = WishList::where('user_id',$user_id)->where('variant_id',$variant_id)->first();
        if($wishlist){
            $data['status'] = 'removed';
            $wishlist->delete();
        }else{
            $wishlist = new WishList();
            $wishlist->user_id = $user_id;
            $wishlist->variant_id =$variant_id;
            $wishlist->save();
            $data['status'] = 'added';
        }
        return json_encode($data);
    }
}
