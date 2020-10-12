<?php

namespace App\Http\Controllers\Migas;

use App\Models\Cart;
use App\Models\Products\Variants;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CartController extends Controller
{

    public function redirect($type,$message){
        session()->flash($type,$message);
        return redirect('cart');
    }

    public function cart(){
        $cart = Cart::where('user_id',$this->user_id())->get();
        return view('hykon.pages.cart',compact('cart'));
    }

    public function add_to_cart(Request $request){

        //Decrypt
        $request->variant_id = decrypt($request->variant_id);
        $request->quantity = decrypt($request->quantity);

        //Check product exist
            $variant = Variants::find($request->variant_id);
            if(!$variant){
                return $this->redirect('error_log','Product is not valid, failed to add to cart');
            }else{
                if(empty($variant->inventory)){
                    return $this->redirect('error_log','Product is not valid, failed to add to cart');
                }
            }
            if($variant->inventory->sale_price<=0){
                return $this->redirect('error_log','Product is not valid, failed to add to cart');
            }

        //Check it already added in cart
            $cart = Cart::where('user_id',$this->user_id())->where('product_id',$variant->id)->first();
            if(!$cart){
                $cart = new Cart;
            }

        //Check it available in stock and active
            if(!Variants::inStock($variant->id,'check')){
                return $this->redirect('error_log','Product is not available in stock, please try after some time');
            }

            $stock = Variants::inStock($variant->id);
            if($request->quantity+$cart->quantity > $stock){
                $cart->quantity = $stock;
            }else{
                $cart->quantity = $request->quantity+$cart->quantity;
            }

            if($cart->quantity == 0){
                $cart->delete();
                return $this->redirect('waring_log','Product is removed from your cart');
            }


            //Add to cart
            $cart->user_id = $this->user_id();
            $cart->product_id = $variant->id;

            $cart->price = $variant->inventory->sale_price;
            $cart->retail_price = $variant->inventory->retail_price;
            $cart->sale_price = $variant->inventory->sale_price;
            $cart->save();
            return $this->redirect('success_log','Product is successfully added to cart');
    }

}
