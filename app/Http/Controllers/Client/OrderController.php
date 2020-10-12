<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\BaseController;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Orders;
use App\Models\Orders\OrderDetails;
use App\Models\Orders\OrderStatusLabel;
use App\Models\Orders\CancelOrderReason;
use App\Models\Orders\OrderTracking;
use DB, Validator, Auth, Redirect, Hash, PDF;

class OrderController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $user_id = $user->id;
        $orders = Orders::where('users_id', $user_id)->orderBy('created_at', 'DESC')->paginate(10);
        return view('client.orders.index', ['orders'=>$orders]);
    }

    public function order_details($order_id)
    {
    	$user = Auth::user();
        $user_id = $user->id;
    	$order = Orders::where('order_reference_number', $order_id)->where('users_id', $user_id)->first();
    	if($order)
    	{
            $status = new OrderStatusLabel;

    		$order_status = OrderStatusLabel::where('type', 'N')->orderBy('display_order', 'ASC')->get();
    		return view('client.orders.details', ['order'=>$order, 'order_status'=>$order_status, 'status'=>$status]);
    	}
    	else
    		abort('404');
    }

    public function cancel_order($order_id)
    {
        $cancel_reasons = CancelOrderReason::orderBy('display_order', 'ASC')->get();
        return view('client.orders.cancel_order', ['cancel_reasons'=>$cancel_reasons, 'order_id'=>$order_id]);
    }

    public function cancel_order_save(Request $request)
    {

        $validatedData = $request->validate([
            'cancel_reason' => 'required|max:255',
            'other_reason' => 'required_if:cancel_reason,==,Other',
        ]);
        $id = decrypt($request->id);

        $cancel_status = OrderStatusLabel::where('type', 'C')->orderBy('display_order', 'ASC')->value('id');

        $tracking = new OrderTracking;
        $tracking->order_details_id = $id;
        $tracking->order_status_labels_master_id = $cancel_status;
        $tracking->notes = ($request->cancel_reason == 'Other')?$request->other_reason:$request->cancel_reason;;
        if($tracking->save())
        {
            $order = OrderDetails::find($id);
            $order->status = $cancel_status;
            $order->save();
        }
        return response()->json(['success' => 'Order cancel request has been successfully sent.']);
    }

    public function invoice($order_id){
        $order =Orders::where('order_reference_number',$order_id)->first();
        $ordertotalinwords = BaseController::getIndianCurrency($order->total_sale_price);
        $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadView('client.pdf.invoice', compact('order','ordertotalinwords'));
        return $pdf->stream('invoice.pdf');
//        return view('client.pdf.invoice', compact('order','ordertotalinwords'));
    }

}