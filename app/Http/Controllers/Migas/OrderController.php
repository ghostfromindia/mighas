<?php

namespace App\Http\Controllers\Migas;

use App\Models\Address;
use App\Models\Cart;
use App\Models\Orders;
use App\Models\Orders\OrderDetails;
use App\Models\Orders\OrderTracking;
use App\Models\Products\Variants;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Razorpay\Api\Api;

class OrderController extends Controller
{

    private $api_key = 'rzp_test_fR1BRBkp6UDaHU';
    private $api_secret = 'eu4YNccTPsLnWPHa79Xmz9fg';

    public function redirect($type,$message){
        session()->flash($type,$message);
        return redirect('cart');
    }

    public function order_create(Request $request){
        $user = Auth::user()->id;
        $cart = Cart::where('user_id',$user)->get();
        $address = Address::find(decrypt($request->address));

        if(!$address){
            session()->flash('error_log','Please choose an address to continue');
            return redirect('checkout/address');
        }

        $total_mrp = $total_discount = $total_sale_price = $total_final_price = 0;

        // Cart Validation
        foreach ($cart as $obj){

            //Check product exist
            $variant = Variants::find($obj->product_id);
            if(!$variant){
                return $this->redirect('error_log','Some products in your cart not valid anymore, failed to create an order');
            }else{
                if(empty($variant->inventory)){
                    return $this->redirect('error_log','Some products in your cart not valid anymore, failed to create an order');
                }
            }
            if($variant->inventory->sale_price<=0){
                return $this->redirect('error_log','Some products in your cart not valid anymore, failed to create an order');
            }

            //Check it available in stock and active
            if(!Variants::inStock($variant->id,'check')){
                return $this->redirect('error_log','Product is not available in stock, please try again later');
            }

            $total_mrp = $total_mrp + ($obj->retail_price*$obj->quantity);
            $total_sale_price = $total_sale_price + ($obj->sale_price*$obj->quantity);
            $total_final_price = $total_final_price + ($obj->price*$obj->quantity);

        }

        $transaction_id = 'HYK'.date('ymd').'ODR'.date('s').rand(1111,2222);



        $order = new Orders();
        $order->users_id = Auth::user()->id;
        $order->transaction_id = $transaction_id;
        $order->status = 'payment_started';
        $order->order_reference_number = $transaction_id;
        $order->total_mrp = $total_mrp;
        $order->total_discount = $total_mrp - $total_final_price;
        $order->total_sale_price = $total_sale_price;
        $order->total_final_price = $total_final_price;
        $order->payment_method = $request->payment_method;
        $order->delivery_address_id = $address->id;
        $order->delivery_instructions = $request->delivery_notes;
        $order->save();


        foreach ($cart as $obj) {
            $order_details = new OrderDetails;
            $order_details->orders_id = $order->id;
            $order_details->products_id = $obj->product_id;
            $order_details->mrp = $obj->retail_price;
            $order_details->quantity = $obj->quantity;
            $order_details->sale_price = $obj->sale_price;
            $order_details->price = $obj->price;
            $order_details->discount = $obj->retail_price-$obj->price;
            $order_details->status = 0;
            $order_details->save();
        }

        session()->put('order',$order->id);

        if($request->payment_method == 'cod'){
            Cart::where('user_id',Auth::user()->id)->delete();
            $order = Orders::find(decrypt($request->og));
            $order->payment_status = 1;
            $order->status = 'cod';
            $order->save();


            foreach ($order->details as $obj){

                $order = Orders::find($order->id);
                $order->payment_status = 1;
                $order->status = 'cod';
                $order->save();

                $item = OrderDetails::find($obj->id);
                $item->status = 1;
                $item->save();

                $order_status = new OrderTracking;
                $order_status->order_details_id = $item->id;
                $order_status->order_status_labels_master_id = 1;
                $order_status->save();

            }
            return redirect('account/orders');
        }else{
            $api = new Api($this->api_key, $this->api_secret);

            $order_payment = $api->order->create(array(
                    'receipt' => $transaction_id,
                    'amount' => $total_final_price*100,
                    'payment_capture' => 1,
                    'currency' => 'INR'
                )
            );

            $key = $this->api_key;

            //online payment redirection
            return view('hykon.pages.checkout.payment',compact('order','order_payment','key'));
        }




    }
    public function verify_payment($razorpay_signature,$razorpay_payment_id,$razorpay_order_id){
        try{
            $api = new Api($this->api_key, $this->api_secret);
            $attrbutes  = array('razorpay_signature'  => $razorpay_signature,  'razorpay_payment_id'  => $razorpay_payment_id ,  'razorpay_order_id' => $razorpay_order_id);
            $order  = $api->utility->verifyPaymentSignature($attrbutes);
            return true;
        }catch (\Exception $e){

        }
    }

    public function payment_response(Request $request){
        $payment_status = $this->verify_payment($request->razorpay_signature,$request->razorpay_payment_id,$request->razorpay_order_id);
        if($payment_status == true){
            Cart::where('user_id',Auth::user()->id)->delete();
            $order = Orders::find(decrypt($request->og));
            $order->payment_status = 1;
            $order->status = 'payment_completed';
            $order->save();


            foreach ($order->details as $obj){

                $item = OrderDetails::find($obj->id);
                $item->status = 1;
                $item->save();

                $order_status = new OrderTracking;
                $order_status->order_details_id = $item->id;
                $order_status->order_status_labels_master_id = 1;
                $order_status->save();

            }
            return redirect('account/orders');
        }else{
            return view('checkout/payment/failed');
        }
    }


}
