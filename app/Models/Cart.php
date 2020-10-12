<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'cart';



    public function product(){
        return $this->belongsTo('App\Models\Products\Variants','product_id');
    }

    public function coupon(){
        return $this->belongsTo('App\Models\Coupon','cart_offer_id');
    }

    public function offer(){
        return $this->belongsTo('App\Models\Offers','product_offer_id');
    }

    public static function count($id){
        $cart = Cart::where('user_id',$id)->get();
        return count($cart);
    }

    public static function total($id){
        $cart = Cart::where('user_id',$id)->get();
        $total = 0;
        $data = [];
        $data['total'] = 0;
        $data['coupon_discount'] = 0;
        $data['coupon_message'] = 'Apply your promo code above';


        if(count($cart)>0){

            foreach ($cart as $obj){
                $total = $total + $obj->price * $obj->quantity;
            }

            $data['total'] = $total;
            $cart = $cart->first();

            if($cart->cart_offer_id){
                $coupon_name = Coupon::find($cart->cart_offer_id)->coupon_code;
                $coupon = Coupon::where('id',$cart->cart_offer_id)->where('minimum_purchase_value','<=',$total)->first();

                if($coupon){

                        if($coupon->discount_type == 'Percentage'){
                            $discount = (($total*$coupon->discount_percentage)/100);
                        }else{
                            $discount = $coupon->discount_amount;
                        }

                        if($coupon->maximum_discount_value < $discount){
                            $discount = $coupon->maximum_discount_value;
                            $total = $total - $discount;
                        }else{
                            $total = $total - $discount;
                        }

                    $data['coupon_discount'] = $discount;
                    $data['coupon_message'] = '<div style="color: green;display: block;width: 100%">Coupon '.$coupon_name.' is applied successfully with this cart. <span class="remove_coupon" data-id="'.encrypt($obj->id).'">- Remove</span></div>';
                }else{
                    $data['coupon_message'] = '<div style="color: red;display: block;width: 100%">Coupon '.$coupon_name.' is invalid with this cart. <span class="remove_coupon" data-id="'.encrypt($obj->id).'">- Remove</span></div>';
                }
            }
        }

        $data['final_total'] =  $data['total'] - $data['coupon_discount'];

        return $data;
    }

    public static function CartParent($id){
        return $cart = Cart::where('user_id',$id)->orderBy('product_offer_id')->orderBy('offer_parent')->get();
    }

    public static function cart_list($id){
        $cart = Cart::where('user_id',$id)->get();
        $data = [];

        $data['products'] = [];

        $data['coupon_id'] = 0;
        $data['coupon_discount'] = 0;
        $data['total_mrp'] = 0;
        $data['total_discount'] = 0;
        $data['total_sale_price'] = 0;

        $row['products_id'] = null;
        $row['cart_offer_id'] = null;
        $row['product_offer_id'] = null;
        $row['mrp'] = 0;
        $row['quantity'] = 0;
        $row['sale_price'] = 0;
        $row['discount'] = 0;

        //checking for invalid offer. If any invalid offer found then products related to offer will be removed and primary product will be re-added.
        foreach ($cart as $obj){
            if($obj->product_offer_id){  //checking for offer id.
                if(!Offers::isValid($obj->product_offer_id)){
                    Cart::where('product_offer_id',$obj->product_offer_id)->where('user_id',$id)->destroy();
//                    Cart::where('cart_offer_id',)
                }
            }
        }
    }

    public static function assign_cart($id){
        if(session()->has('guest')){
            $cart = Cart::where('user_id',session('guest'))->get();
            foreach ($cart as $obj){
                $obj->user_id = $id;
                $obj->save();
            }
        }
        return true;
    }


}
